<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class StudentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

            return new Student([
                'register_date' => $row['Registeration Date'],
                'effective_date_of_certificate' => $row['Effective Date of Certificate'],
                'registration_no' => $row['Registration No'],
                'reference_no' => $row['Reference No'],
                'certificate_no' => $row['Certificate No'],
                'batch_id' => $row['Batch ID'],
                'full_name_of_student' => $row['Full Name of Student'],
                'name_with_initial' => $row['Name With Initial'],
                'nic_no' => $row['NIC No'],
                'address' => $row['Address'],
                'course_name' => $row['Course Name'],
                'year' => $row['Year'],
            ]);

    }
}
