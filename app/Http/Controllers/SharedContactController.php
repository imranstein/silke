<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\SharedContact;
use Illuminate\Support\Facades\Auth;

class SharedContactController extends Controller
{
    public function share(Request $request)
    {
        $fromUser = Auth::user()->id;
        $contactId = $request->contact_id;

        foreach ($request->toUsers as $user) {

            $sharedContact = SharedContact::create([
                'from_user_id' => $fromUser,
                'to_user_id' => $user,
                'contact_id' => $contactId,
            ]);
        }

        return redirect()->route('contacts')
            ->with('update', 'Contact shared,Wait For Acceptance');
    }

    public function accept($id)
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

        return redirect()->route('contacts')
            ->with('success', 'Contact Accepted');
    }

    public function reject($id)
    {
        $sharedContact = SharedContact::find($id);
        //    delete shared contact
        $sharedContact->delete();

        return redirect()->route('contacts')
            ->with('delete', 'Contact Rejected');
    }
}
