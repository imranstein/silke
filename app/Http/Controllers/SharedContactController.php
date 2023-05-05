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

        $fromUser = Auth::user()->id;
        $contactId = $request->contact_id;
        $contact = Contact::find($contactId);
        $name = $contact->name;
        $phone = $contact->phone;
        $from = Auth::user()->name;

        foreach ($request->toUsers as $user) {

            $sharedContact = SharedContact::create([
                'from_user_id' => $fromUser,
                'to_user_id' => $user,
                'contact_id' => $contactId,
            ]);
            $id = $sharedContact->id;
            // send notification about a contact being share with them
            $to = User::find($user);
            $to->notify(new ContactShareNotification($from, $name, $phone, $id));
        }


        return redirect()->route('contact.show', $contactId)
            ->with('update', 'Contact shared,Wait For Acceptance');
    }

    public function accept($id, $nid)
    {
        $sharedContact = SharedContact::find($id);
        $sharedContact->accepted_at = now();
        $sharedContact->save();

        $contact = Contact::find($sharedContact->contact_id);

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
        if ($nid != null) {
            $notification = Auth::user()->notifications->where('id', $nid)->first();
            $notification->markAsRead();
        }

        return redirect()->route('contacts')
            ->with('success', 'Contact Accepted');
    }
}
