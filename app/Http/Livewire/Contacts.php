<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\ContactExport;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BirthdayWishNotification;
use App\Notifications\BirthdayReminderNotification;

class Contacts extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $paginate = 10;

    public $name;

    public $email;

    public $phone;

    public $alt_phone;

    public $address;

    public $dob;

    public $image;

    public $contact_id;

    public $isOpen = 0;

    public $checked = [];

    public $selectPage = false;

    public $selectAll = false;

    public $columns = ['Id', 'Name', 'Email', 'Phone', 'Alt_Phone', 'Address'];

    public $selectedColumns = [];

    public $sortColumn = 'created_at';

    public $sortOrder = 'desc';

    //Sorting By feature
    public function sortBy($field)
    {
        if ($this->sortColumn === $field) {
            $this->sortOrder = $this->sortOrder === 'desc' ? 'asc' : 'desc';
        } else {
            $this->sortOrder = 'desc';
        }
        $this->sortColumn = $field;
    }

    //This is for column visibility on the render of the page
    public function mount()
    {
        $this->selectedColumns = $this->columns;
    }

    //this is for visibility of olumn
    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    //this is the index method
    public function render()
    {
        $birthdays = Contact::where('user_id', auth()->user()->id)->whereRaw('DAYOFYEAR(NOW()) = DAYOFYEAR(dob)')->get();

        $upcomings = Contact::where('user_id', auth()->user()->id)->whereRaw('DAYOFYEAR(NOW()) <= DAYOFYEAR(dob) AND DAYOFYEAR(NOW()) + 5 >= DAYOFYEAR(dob)')->get();
        $from = Auth::user()->name;
        foreach ($birthdays as $birthday) {
            // send a message using notification mail for the contacts email
            $name = $birthday->name;
            $birthday->notify(new BirthdayWishNotification($from, $name));
        }
        $user = User::find(auth()->user()->id);
        foreach ($upcomings as $upcoming) {
            // send reminder to the auth user about the upcoming birthdays in notification and also mail
            $name = $upcoming->name;
            // just show the Moth and data
            $date = date('M d', strtotime($upcoming->dob));
            $user->notify(new BirthdayReminderNotification($name, $date));
        }
        $contacts = Contact::where('user_id', auth()->user()->id)->search(trim($this->search))->orderBY($this->sortColumn, $this->sortOrder)->paginate($this->paginate);

        return view('contact.index', compact('contacts'));
    }

    //this checks if the check box is activated

    public function isChecked($student_id)
    {
        return in_array($student_id, $this->checked);
    }

    //this is to delete
    public function deleteRecords()
    {
        Contact::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('delete', 'Selected Records were deleted Successfully');
    }

    //this is to update the whole page
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = Contact::where('user_id', auth()->user()->id)->search(trim($this->search))->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->checked = [];
        }
    }

    //this are to export the table in different format
    public function exportSelected()
    {
        $date = date('d-m-y');

        return (new ContactExport)->forChecked($this->checked)->download('contacts' . $date . '.csv');
    }

    public function excelSelected()
    {
        $date = date('d-m-y');

        return (new ContactExport)->forChecked($this->checked)->download('contacts' . $date . '.xlsx');
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->contactsQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }
}
