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
            'Picture',
            'Registeration Date',
            'Effective Date of Certificate',
            'Batch No',
            'Study Mode',
            'Pass Rate',
            'Full Name of Student',
            'Name With Initial',
            'NIC No',
            'Address',
            'Course Name',
            'Short Name',
            'Course Duration',
            'Course Year',

        ];
    }

    public function collection()
    {
        // Return an empty collection
        return collect([]);
    }
}
