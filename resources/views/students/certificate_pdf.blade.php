<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            background-image: url("assets/certificate-images/certificate-template.png");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: contain;
            /* Adjusted to fit within A4 size */
            height: 100vh;
            /* Ensure the body takes up the full viewport height */
            width: 100%;
            /* Ensure the body takes up the full width */
            margin: 0;
            padding: 0;
        }

        #studentName {
            position: absolute;
            top: 42%;
            /* Adjust this value to move the name up or down */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 25px;
            font-weight: bold;
            color: #6a00d1;
            /* Adjust color to match the certificate theme */
        }

    </style>
</head>
<body>

    {{-- <p>Registration Date: {{ $student->register_date }}</p>
    <p>Effective Date of Certificate{{ $student->effective_date_of_certificate }}</p>
    <p>Full Name of Student{{ $student->full_name_of_student }}</p>
    <p>Reference No{{ $student->reference_no }}</p>
    <p>Name With Initial {{ $student->name_with_initial }}</p>
    <p>Registration No: {{ $student->registration_no }}</p>
    <p>Certificate No: {{ $student->certificate_no }}</p>
    <p>NIC No: {{ $student->nic_no }}</p>
    <p>Address: {{ $student->address }}</p>
    <p>Course Name: {{ $course->course_name }}</p>
    <p>Year: {{ $student->batch->course_year }}</p>
    <p>Batch No: {{ $student->batch->batch_no }}</p> --}}


    <div id="studentName">
        <p>{{ $student->full_name_of_student }}</p>
    </div>

</body>
</html>
