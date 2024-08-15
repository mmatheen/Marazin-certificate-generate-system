<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExportTemplate implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID',
            'Registeration Date',
            'Effective Date of Certificate',
            'Registration No',
            'Reference No',
            'Certificate No',
            'Batch ID',
            'Full Name of Student',
            'Name With Initial',
            'NIC No',
            'Address',
            'Course Name',
            'Year',
            'created_at',

        ];
    }

    public function collection()
    {
        // Return an empty collection
        return collect([]);
    }
}
