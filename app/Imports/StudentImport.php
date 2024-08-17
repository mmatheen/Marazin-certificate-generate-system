<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
       // dd($row); // This will stop execution and dump the row data

        return new Student([
            'register_date' => $row['registeration_date'],
            'effective_date_of_certificate' => $row['effective_date_of_certificate'],
            'registration_no' => $row['registration_no'],
            'reference_no' => $row['reference_no'],
            'certificate_no' => $row['certificate_no'],
            'batch_id' => $row['batch_id'],
            'full_name_of_student' => $row['full_name_of_student'],
            'name_with_initial' => $row['name_with_initial'],
            'nic_no' => $row['nic_no'],
            'address' => $row['address'],
            'course_name' => $row['course_name'],
            'year' => $row['year'],
        ]);
    }
}
