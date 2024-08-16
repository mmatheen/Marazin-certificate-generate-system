
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        .certificate-container {
            position: relative;
            display: inline-block;
            margin-top: 50px;
        }

        .certificate-container img {
            width: 100%;
            max-width: 800px;
            height: auto;
        }

        .name {
            position: absolute;
            top: 45%; /* Adjust this value to move the name up or down */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            font-weight: bold;
            color: #6a00d1; /* Adjust color to match the certificate theme */
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <img src="assets/certificate-images/certificate-template.png" alt="Certificate">
        <div class="name" id="nameText">{{ $student->full_name_of_student }}</div>
    </div>

</body>
</html>




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
