<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $contacts;

    protected $selectedColumns;


    public function forChecked($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function query()
    {
        $contact = Contact::query()->whereKey($this->contacts);

        return $contact;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Alt Phone',
            'Address',
            'DOB',
        ];
    }

    public function map($contact): array
    {
        return [
            $contact->name,
            $contact->email,
            $contact->phone,
            $contact->alt_phone,
            $contact->address,
            $contact->dob,
        ];
    }
}
