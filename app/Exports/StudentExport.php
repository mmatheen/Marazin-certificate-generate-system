<?php

namespace App\Exports;
use App\Models\Student;
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
        return Student::select(
            'id',
            'register_date',
            'effective_date_of_certificate',
            'registration_no',
            'reference_no',
            'certificate_no',
            'batch_id',
            'full_name_of_student',
            'name_with_initial',
            'nic_no',
            'address',
            'course_name',
            'year',
            'created_at',
        )->get();
    }
}
