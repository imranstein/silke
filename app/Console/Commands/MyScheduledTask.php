<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Console\Command;
use App\Notifications\BirthdayWishNotification;

class MyScheduledTask extends Command
{
    protected $signature = 'command:name';

    protected $description = 'Command description';

    public function handle()
    {
        $birthdays = Contact::whereRaw('DAYOFYEAR(NOW()) = DAYOFYEAR(dob)')->get();

        foreach ($birthdays as $birthday) {
            $from = User::find($birthday->user_id)->name;
            $name = $birthday->name;
            $birthday->notify(new BirthdayWishNotification($from, $name));
        }
    }
}
