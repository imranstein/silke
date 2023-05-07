<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class DashboardController
{
    /**
     * Display the dashboard.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Contracts\View\View The dashboard view with contact statistics.
     */
    public function __invoke(Request $request)
    {
        // Get the count of contacts for the authenticated user
        $contacts = Contact::where('user_id', auth()->id())->count();

        // Get the count of birthdays for the authenticated user's contacts that match today's day of year
        $birthdays = Contact::where('user_id', auth()->user()->id)->whereRaw('DAYOFYEAR(NOW()) = DAYOFYEAR(dob)')->count();

        // Get the upcoming birthdays for the authenticated user's contacts within the next 5 days
        $upcomings = Contact::where('user_id', auth()->user()->id)->whereRaw('DAYOFYEAR(NOW()) <= DAYOFYEAR(dob) AND DAYOFYEAR(NOW()) + 5 >= DAYOFYEAR(dob)')->get();

        // Return the dashboard view with the contact statistics
        return view('dashboard', compact('contacts', 'birthdays', 'upcomings'));
    }
}
