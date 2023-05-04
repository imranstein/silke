<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Termwind\Components\Dd;

class ContactImport implements ToCollection
{
    protected $id;
    protected $maxId;

    public function __construct($id, $maxId)
    {
        $this->id = $id;
        $this->maxId = $maxId;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {

        $rows->shift();
        $error = null;
        foreach ($rows as $row) {
            if ($row[0] != null) {
                try {
                    Contact::create([
                        // 'id' => $this->maxId++,
                        'user_id' => $this->id,
                        'name' => $row[0],
                        'email' => $row[1],
                        'phone' => $row[2],
                        'alt_phone' => $row[3],
                        'address' => $row[4],
                        'dob' => $row[5],
                    ]);

                } catch (\Exception $e) {
                    // dd($e);
                    $error = 'Please check your excel file';
                }
            }
        }

        if ($error != null) {
            return redirect()->route('contacts')->with('delete', $error);
        } else {
            return redirect()->route('contacts')->with('success', 'Data imported successfully');
        }
    }
}
