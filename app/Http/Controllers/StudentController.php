<?php

namespace App\Http\Controllers;

use App\Exports\StudentExportTemplate;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class StudentController extends Controller
{
    public function studentCertificate()
    {
        // Retrieve the authenticated student's details
        $student = auth()->guard('student')->user();

        // Retrieve the course details through the student's batch
        $course = $student->batch->course;

        // Prepare the data to pass to the Blade view
        $data = [
            'student' => $student,
            'course' => $course,
        ];

        return view('certificate_page.certificate_page', $data);
    }

    public function studentMultipleImageUpload()
    {
        return view('students.multiple_image_upload.student_multiple_image_upload');
    }

    public function uploadImages(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'images' => 'required|array|min:1', // Ensure 'images' is an array and has at least one file
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each file in the array
            ],
            [
                'images.required' => 'Please select at least one image to upload.',
                'images.array' => 'The images field must be an array.',
                'images.min' => 'Please select at least one image to upload.',
                'images.*.required' => 'Please select a valid image file.',
                'images.*.image' => 'The selected file must be an image.',
                'images.*.mimes' => 'Only images of type jpeg, png, jpg, and gif are allowed.',
                'images.*.max' => 'Each image must not exceed 2MB in size.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $imagePaths = []; // To store the paths of uploaded images

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) { // Check if the file is valid
                        $fileName = $image->getClientOriginalName(); // Use the original filename
                        $image->move(public_path('images'), $fileName);
                        $imagePaths[] = 'images/' . $fileName; // Save the path to array
                    }
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Images uploaded successfully!',
                'images' => $imagePaths
            ]);
        }
    }


    public function generatePDF()
    {
        // Retrieve the authenticated student's details
        $student = auth()->guard('student')->user();

        // Retrieve the course details through the student's batch
        $course = $student->batch->course;

        // Prepare the data to pass to the Blade view
        $data = [
            'student' => $student,
            'course' => $course,
        ];

        // Generate the PDF using the Blade view
        $pdf = PDF::loadView('students.certificate_pdf', $data)
            ->setPaper('A4', 'portrait');

        // Download the PDF
        return $pdf->download($student->name_with_initial . '.pdf'); //'certificate.pdf'
    }





    public function student()
    {

        //   $batches = Batch::select('id', 'batch_no', 'course_year')->distinct()->get();
        $batches = Batch::selectRaw('MIN(id) as id, batch_no, course_year,course_duration')->groupBy('batch_no', 'course_year','course_duration')->get();
        $courses = Course::all();

        return view('students.student', compact('courses', 'batches'));
    }

    public function index()
    {

        $students = Student::with('batch.course')->get();

        if ($students->count() > 0) {
            return response()->json([
                'status' => 200,
                'message' => $students
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Records Found!"
            ]);
        }
    }


    public function showBatchDetailsUsingByCourseId(string $course_id)
    {
        $courseName = Batch::where('course_id', $course_id)->select('id', 'batch_no', 'course_year','course_duration')->orderBy('batch_no', 'asc')->get();
        if ($courseName) {
            return response()->json([
                'status' => 200,
                'message' => $courseName
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such record Found!"
            ]);
        }
    }

    public function showBatchDetailsUsingByBatchId(string $batch_id)
    {
        $batchNo = Batch::where('id', $batch_id)->select('id', 'course_year','course_duration')->orderBy('course_year', 'desc')->get();
        if ($batchNo) {
            return response()->json([
                'status' => 200,
                'message' => $batchNo
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such record Found!"
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // auto increment code for certificate_no start
        $year = $request->year;
        $latestCertificate = Student::whereRaw("SUBSTRING(certificate_no, 1, 4) = ?", [$year])->orderBy('certificate_no', 'desc')->first();

        if ($latestCertificate) {
            $latestSequenceNo = intval(substr($latestCertificate->certificate_no, 4));
            $nextSequenceNo = $latestSequenceNo + 1;
        } else {
            $nextSequenceNo = 1;
        }
        $certificateNo = $year . sprintf("%06d", $nextSequenceNo);

        // auto increment code for certificate_no end


        // auto increment code for registration_no start

        $courseId = $request->course_name; // Fetch course ID from request but this is forign key
        $course = Course::find($courseId); // Get the course record checking and getting from course table

        $prefix = 'IATSL/' . $course->short_name . '/'.$year;

        $latestRegistration = Student::whereRaw("SUBSTRING(registration_no, 1, LENGTH(?)) = ?", [$prefix, $prefix])->orderBy('registration_no', 'desc')->first();

        if ($latestRegistration) {
            $latestSequenceNo = intval(substr($latestRegistration->registration_no, strlen($prefix)));
            $nextSequenceNo = $latestSequenceNo + 1;
        } else {
            $nextSequenceNo = 1;
        }
        $registrationNo = $prefix . sprintf("%06d", $nextSequenceNo);

        // auto increment code for registration_no end


        $validator = Validator::make(
            $request->all(),
            [
                'register_date' => 'required',
                'effective_date_of_certificate' => 'required',
                'batch_id' => 'required',
                'full_name_of_student' => 'required',
                'name_with_initial' => 'required',
                'nic_no' => 'required|unique:students',
                'address' => 'required',
                'course_name' => 'required',
                'course_duration' => 'required',
                'year' => 'required',
                'pass_rate' => 'required',
                'study_mode' => 'required',
                'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {

            // File Upload Logic
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $fileName = time() . '.' . $file->extension();
                $file->move(public_path('images'), $fileName);
            } else {
                $fileName = null; // Set default value if no file is uploaded
            }
            // File Upload Logic finished \

            $getValue = Student::create([
                'register_date' => $request->register_date,
                'effective_date_of_certificate' => $request->effective_date_of_certificate,
                'registration_no' => $registrationNo,
                'certificate_no' => $certificateNo,
                'batch_id' => $request->batch_id,
                'full_name_of_student' => $request->full_name_of_student,
                'name_with_initial' => $request->name_with_initial,
                'nic_no' => $request->nic_no,
                'address' => $request->address,
                'course_name' => $request->course_name,
                'course_duration' => $request->course_duration,
                'year' => $request->year,
                'pass_rate' => $request->pass_rate,
                'study_mode' => $request->study_mode,
                'picture' => $fileName,

            ]);


            if ($getValue) {
                return response()->json([
                    'status' => 200,
                    'message' => "New Student Details Created Successfully!"
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong!"
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $getValue = Student::find($id);
        if ($getValue) {
            return response()->json([
                'status' => 200,
                'message' => $getValue
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Student Found!"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $getValue = Student::with('batch.course')->find($id);
        if ($getValue) {
            return response()->json([
                'status' => 200,
                'message' => $getValue
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Student Found!"
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        // auto increment code for certificate_no start
        $year = $request->year;
        $latestCertificate = Student::whereRaw("SUBSTRING(certificate_no, 1, 4) = ?", [$year])->orderBy('certificate_no', 'desc')->first();

        if ($latestCertificate) {
            $latestSequenceNo = intval(substr($latestCertificate->certificate_no, 4));
            $nextSequenceNo = $latestSequenceNo + 1;
        } else {
            $nextSequenceNo = 1;
        }
        $certificateNo = $year . sprintf("%06d", $nextSequenceNo);

        // auto increment code for certificate_no end


        // auto increment code for registration_no start

        $courseId = $request->course_name; // Fetch course ID from request but this is forign key
        $course = Course::find($courseId); // Get the course record checking and getting from course table

        $prefix = 'IATSL/' . $course->short_name . '/';

        $latestRegistration = Student::whereRaw("SUBSTRING(registration_no, 1, LENGTH(?)) = ?", [$prefix, $prefix])->orderBy('registration_no', 'desc')->first();

        if ($latestRegistration) {
            $latestSequenceNo = intval(substr($latestRegistration->registration_no, strlen($prefix)));
            $nextSequenceNo = $latestSequenceNo + 1;
        } else {
            $nextSequenceNo = 1;
        }
        $registrationNo = $prefix . sprintf("%06d", $nextSequenceNo);

        // auto increment code for registration_no end

        $validator = Validator::make(
            $request->all(),
            [
                'register_date' => 'required',
                'effective_date_of_certificate' => 'required',
                'batch_id' => 'required',
                'full_name_of_student' => 'required',
                'name_with_initial' => 'required',
                'nic_no' => 'required',
                'address' => 'required',
                'course_name' => 'required',
                'course_duration' => 'required',
                'year' => 'required',
                'pass_rate' => 'required',
                'study_mode' => 'required',
                'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $getValue = Student::find($id);

            // File Upload Logic
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $fileName);


                // Delete old image if it exists and is a file
                $oldimagePath = public_path('images') . '/' . $getValue->picture;
                if (file_exists($oldimagePath) && is_file($oldimagePath)) {
                    unlink($oldimagePath);
                }
            } else {
                $fileName = $getValue->picture; // Set default value if no file is uploaded
            }
            //image code end

            if ($getValue) {
                $getValue->update([

                    'register_date' => $request->register_date,
                    'effective_date_of_certificate' => $request->effective_date_of_certificate,
                    'batch_id' => $request->batch_id,
                    'full_name_of_student' => $request->full_name_of_student,
                    'name_with_initial' => $request->name_with_initial,
                    'nic_no' => $request->nic_no,
                    'certificate_no' => $certificateNo,
                    'registration_no' => $registrationNo,
                    'address' => $request->address,
                    'course_name' => $request->course_name,
                    'course_duration' => $request->course_duration,
                    'year' => $request->year,
                    'pass_rate' => $request->pass_rate,
                    'study_mode' => $request->study_mode,
                    'picture' => $fileName,

                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Old Student Details Updated Successfully!"
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "No Such Student Found!"
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $getValue = Student::find($id);
        if ($getValue) {

            // delete old image
            $imagePath = public_path('images') . '/' . $getValue->picture;
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
            // delete old image finish

            $getValue->delete();
            return response()->json([
                'status' => 200,
                'message' => "Student Details Deleted Successfully!"
            ]);
        } else {

            return response()->json([
                'status' => 404,
                'message' => "No Such Student Found!"
            ]);
        }
    }



    public function importStudentPage()
    {
        return view('students.import_student');
    }
    public function exportBlankTemplate()
    {
        return Excel::download(new StudentExportTemplate, 'Student Blank Template.xlsx');
    }
    public function export()
    {
        return Excel::download(new StudentExport, 'Student Details.xlsx');
    }



    public function importStudentStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }
        // Check if file is present in the request
        if ($request->hasFile('file')) {
            // Get the uploaded file
            $file = $request->file('file');

            // Check if file upload was successful
            if ($file->isValid()) {
                // Process the Excel file

                Excel::import(new StudentImport, $file);
                return response()->json([
                    'status' => 200,
                    'message' => "Student Excel file Uploated successfully!"
                ]);
            }
        }
    }
}
