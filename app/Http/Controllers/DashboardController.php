<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class DashboardController
{
    public function __invoke(Request $request)
    {

        $contacts = Contact::where('user_id', auth()->id())->count();
        $birthdays = Contact::where('user_id', auth()->user()->id)->whereRaw('DAYOFYEAR(NOW()) = DAYOFYEAR(dob)')->count();
        $upcomings = Contact::where('user_id', auth()->user()->id)->whereRaw('DAYOFYEAR(NOW()) <= DAYOFYEAR(dob) AND DAYOFYEAR(NOW()) + 5 >= DAYOFYEAR(dob)')->get();

        return view('dashboard', compact('contacts', 'birthdays', 'upcomings'));
    }
}
