<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Batch;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // dd($row);

    // Convert Excel serial dates to PHP date format
    $registerDate = Date::excelToDateTimeObject($row['registeration_date'])->format('Y-m-d');
    $effectiveDate = Date::excelToDateTimeObject($row['effective_date_of_certificate'])->format('Y-m-d');

    // Find the course based on the course_name
    $course = Course::where('course_name', $row['course_name'])->first();

    // Ensure the course is found
    if (!$course) {
        throw new \Exception('Course not found: ' . $row['course_name']);
    }

    // Find the batch using the batch_no and course_id
    $batch = Batch::where('batch_no', $row['batch_no'])->where('course_id', $course->id)->first();

    // Ensure the batch is found
    if (!$batch) {
        throw new \Exception('Batch not found for batch_no: ' . $row['batch_no'] . ' and course_id: ' . $course->id);
    }

        return new Student([
            'register_date' => $registerDate,
            'effective_date_of_certificate' => $effectiveDate,
            'picture' => $row['picture'],
            'batch_id' => $batch->id,
            'full_name_of_student' => $row['full_name_of_student'],
            'name_with_initial' => $row['name_with_initial'],
            'nic_no' => $row['nic_no'],
            'address' => $row['address'],
            'study_mode' => $row['study_mode'],
            'pass_rate' => $row['pass_rate'],
            'year' => $batch->course_year,
            'course_duration' => $batch->course_duration,
            'course_name' => $course->id,
            'short_name' => $course->short_name,

        ]);
    }
}
