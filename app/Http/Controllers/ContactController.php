<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Imports\ContactImport;
use JeroenDesloovere\VCard\VCard;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;


class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:contact-list|contact-create|contact-edit|contact-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:contact-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:contact-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
    }


    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a new contact in the database.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing the contact data.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the contacts page with a success message.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:contacts,email,NULL,id,user_id,' . Auth::user()->id,
            'phone' => 'required|numeric|digits_between:9,15',
            'alt_phone' => 'nullable|numeric|digits_between:9,15',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date|before:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'latitude' => 'nullable|numeric|min:-90|max:90',
            'longitude' => 'nullable|numeric|min:-180|max:180',
        ]);

        // Create a new Contact instance with the validated data and set the user ID
        $contact = new Contact($validated);
        $contact->user_id = Auth::user()->id;

        // If an image was uploaded, save it to the server and set the image path on the contact
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $contact->image = 'Photo/' . $name_gen;
        }

        // Save the contact to the database
        $contact->save();

        // Redirect to the contacts page with a success message
        return redirect()->route('contacts')->with('success', 'Contact Created successfully');
    }


    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $users = User::whereNotIn('id', [auth()->user()->id])->get();

        return view('contact.show', compact('contact', 'users'));
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return view('contact.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {

        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|numeric|digits_between:9,15',
            'alt_phone' => 'nullable|numeric|digits_between:9,15',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date|before:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'document' => 'nullable|mimes:pdf,doc,docx|max:20048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $contact->image;
        }

        $contact->update(array_merge($validated, ['image' => $last_thumb]));


        return redirect()->route('contacts')->with('update', 'Contact Updated successfully');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts')->with('delete', 'Contact Deleted successfully');
    }

    // This function is used to import contacts from an Excel or CSV file.
    public function import(Request $request)
    {
        // Validate the request to ensure that a file is uploaded and it's of type xls, xlsx or csv.
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        // Get the maximum id of the existing contacts.
        $maxId = Contact::max('id');

        // Get the id of the authenticated user.
        $id = Auth::user()->id;

        // Get the uploaded file.
        $file = $request->file('file');

        // Import the contacts from the file using the ContactImport class and pass the user id and max id as parameters.
        Excel::import(new ContactImport($id, $maxId), $file);

        // Redirect the user to the contacts page.
        return redirect()->route('contacts');
    }


    // This function generates a vCard for a contact and downloads it.
    public function vcf($id)
    {
        // Find the contact with the given id.
        $contact = Contact::findOrFail($id);

        // Create a new VCard object.
        $vcard = new VCard();

        // Add the contact's name to the vCard.
        $vcard->addName($contact->name);

        // Add the contact's phone numbers to the vCard.
        if ($contact->phone) {
            $vcard->addPhoneNumber($contact->phone, 'PREF;WORK');
        }
        if ($contact->alt_phone) {
            $vcard->addPhoneNumber($contact->alt_phone, 'WORK');
        }

        // Add the contact's email address to the vCard.
        if ($contact->email) {
            $vcard->addEmail($contact->email);
        }

        // Add the contact's address to the vCard.
        if ($contact->address) {
            $vcard->addAddress($contact->address);
        }

        // Add the contact's date of birth to the vCard.
        if ($contact->dob) {
            $vcard->addBirthday($contact->dob);
        }

        // Add the contact's photo to the vCard.
        if ($contact->image) {
            $vcard->addPhoto(public_path($contact->image));
        }

        // Download the vCard.
        $vcard->download();

        // Redirect the user to the contacts page.
        return redirect()->route('contacts');
    }


    /**
     * Read a notification with the given ID.
     *
     * @param int $id The ID of the notification to read.
     * @return \Illuminate\Http\RedirectResponse A redirect response to either the shared contact page or the contacts page.
     */
    public function readNotification($id)
    {
        // Retrieve the notification with the given ID for the authenticated user
        $notification = Auth::user()->notifications->find($id);

        // If the notification doesn't exist, redirect to the contacts page
        if (!$notification) {
            return redirect()->route('contacts');
        }

        // Mark the notification as read
        $notification->markAsRead();

        // If the notification is a contact share notification, redirect to the shared contact page
        if ($notification->type == 'App\Notifications\ContactShareNotification') {
            return redirect()->route('shared.show', $notification->data['id']);
        }

        // Otherwise, redirect to the contacts page
        return redirect()->route('contacts');
    }
}
