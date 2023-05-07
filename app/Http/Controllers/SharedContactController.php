<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\SharedContact;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactShareNotification;

class SharedContactController extends Controller
{

    public function share(Request $request)
    {
        // Get the ID of the authenticated user
        $fromUser = Auth::id();
    
        // Find the contact by ID or throw an exception
        $contact = Contact::findOrFail($request->contact_id);
    
        // Create an array of data to be used for creating shared contacts
        $sharedData = [
            'from_user_id' => $fromUser,
            'contact_id' => $contact->id,
        ];
    
        // Loop through each user ID in the request and create a shared contact for them
        foreach ($request->toUsers as $userId) {
            // Add the current user ID to the shared data array
            $sharedData['to_user_id'] = $userId;
    
            // Create a new shared contact using the shared data array
            $sharedContact = SharedContact::create($sharedData);
    
            // Send a notification to the user about the contact being shared
            User::find($userId)->notify(new ContactShareNotification(Auth::user()->name, $contact->name, $contact->phone, $sharedContact->id));
        }
    
        // Redirect back to the contact page with a message indicating that the contact has been shared
        return redirect()->route('contact.show', $contact->id)->with('update', 'Contact shared. Please wait for acceptance.');
    }
    


    /**
     * Show a shared contact.
     *
     * @param int $id The ID of the shared contact.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The shared contact view.
     */
    public function show($id)
    {
        $sharedContact = SharedContact::with('contact')->findOrFail($id);

        return view('contact.shared', ['contact' => $sharedContact->contact, 'id' => $id]);
    }

    public function accept($id)
    {
        // Find the shared contact by ID or return null
        $sharedContact = SharedContact::find($id);
    
        // Update the accepted_at field of the shared contact to the current time
        $sharedContact->update(['accepted_at' => now()]);
    
        // Find the contact associated with the shared contact or return null
        $contact = Contact::find($sharedContact->contact_id);
    
        // Create a new contact using the user_id, name, email, phone, alt_phone, address, dob, and image fields from the original contact
        $newContact = Contact::create([
            'user_id' => $sharedContact->to_user_id,
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'alt_phone' => $contact->alt_phone,
            'address' => $contact->address,
            'dob' => $contact->dob,
            'image' => $contact->image,
        ]);
    
        // Redirect to the contacts page with a success message
        return redirect()->route('contacts')
            ->with('success', 'Contact Accepted');
    }
    

    public function reject($id)
    {
        // Find the shared contact by ID or return null
        $sharedContact = SharedContact::find($id);
    
        // Delete the shared contact from the database
        $sharedContact->delete();
    
        // Redirect to the contacts page with a delete message
        return redirect()->route('contacts')
            ->with('delete', 'Contact Rejected');
    }
    

    public function download()
    {
        // download contact.xlsx file from public
        return response()->download(public_path('sample/contacts.xlsx'));
    }
}
