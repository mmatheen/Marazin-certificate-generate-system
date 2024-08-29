<?php

namespace App\Exports;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'ID',
            'Picture',
            'Registration Date',
            'Effective Date of Certificate',
            'Registration No',
            'Reference No',
            'Certificate No',
            'Batch No',
            'Course Year',
            'Course Name',
            'Full Name of Student',
            'Name With Initial',
            'NIC No',
            'Address',
        ];
    }

    public function collection()
    {
        // Eager load the batch and course relationships
        return Student::with(['batch.course'])->get();
    }

    /**
     * Map the data for each row
     */
    public function map($student): array   //it will getting record from forignkey table record
    {

        // dd($student);

        return [
            $student->id,
            $student->picture,
            $student->register_date,
            $student->effective_date_of_certificate,
            $student->registration_no,
            $student->reference_no,
            $student->certificate_no,
            $student->batch ? $student->batch->batch_no : null,
            $student->batch ? $student->batch->course_year : null,
            $student->batch && $student->batch->course ? $student->batch->course->course_name : null,
            $student->full_name_of_student,
            $student->name_with_initial,
            $student->nic_no,
            $student->address,
           
        ];
    }
}
