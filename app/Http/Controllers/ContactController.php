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

    public function index()
    {
        $count = Contact::count();

        return view('contact.index', compact('count'));
    }

    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:contacts,email,NULL,id,user_id,' . Auth::user()->id,
            'phone' => 'required|numeric|digits_between:9,15',
            'alt_phone' => 'nullable|numeric|digits_between:9,15',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date|before:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        ]);

        $contact = new Contact($validated);
        $contact->user_id = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $contact->image = 'Photo/' . $name_gen;
        }

        $contact->save();


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

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        $maxId = Contact::max('id');
        $id = Auth::user()->id;

        $file = $request->file('file');
        Excel::import(new ContactImport($id, $maxId), $file);

        return redirect()->route('contacts');
    }

    public function vcf($id)
    {
        $contact = Contact::findOrFail($id);

        $vcard = new VCard();

        $name = $contact->name;

        $vcard->addName($name);
        $vcard->addPhoneNumber($contact->phone, 'PREF;WORK');
        $vcard->addPhoneNumber($contact->alt_phone, 'WORK');
        $vcard->addEmail($contact->email);
        $vcard->addAddress($contact->address);
        $vcard->addBirthday($contact->dob);
        $vcard->addPhoto(public_path($contact->image));

        $vcard->download();

        return redirect()->route('contacts');
    }

    public function readNotification($id)
    {
        $notification = Auth::user()->notifications->where('id', $id)->first();
        if ($notification->type == 'App\Notifications\ContactShareNotification') {
            $notification->markAsRead();
            return redirect()->route('shared.show', $notification->data['id']);
        }
        $notification->markAsRead();

        return redirect()->route('contacts');
    }
}
