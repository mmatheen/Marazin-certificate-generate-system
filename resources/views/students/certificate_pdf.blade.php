<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            background-image: url("assets/certificate-images/Online certificate.png");
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
            top: 53%;
            /* Adjust this value to move the name up or down */
            left: 47%;
            transform: translate(-47%, -47%);
            font-size: 25px;
            font-weight: bold;
            /* Adjust color to match the certificate theme */
        }
        #nic{

            position: absolute;
            top: 93%;
            /* Adjust this value to move the name up or down */
            left: 30%;
            transform: translate(-30%, -30%);
            font-size: 14px;
        }
        #link{

            position: absolute;
            top: 95.3%;
            /* Adjust this value to move the name up or down */
            left: 34%;
            transform: translate(-34%, -34%);
            font-size: 15px;

        }
        #pass_rate{
            position: absolute;
            top: 72%;
            /* Adjust this value to move the name up or down */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 20px;
            color: rgb(146, 5, 5);
            font-family: "Roboto", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        #certificate_no{
            position: absolute;
            top: 3%;
            /* Adjust this value to move the name up or down */
            left: 71%;
            font-size: 15px;
            font-family: "Roboto", sans-serif;
            font-weight: 300;
            font-style: normal;

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
    <p>Year: {{ $student->pass_rate }}</p>
    <p>Batch No: {{ $student->batch->batch_no }}</p> --}}


    <div id="studentName">
        <p>{{ $student->full_name_of_student }}</p>
    </div>
    <div id="link">
        <a href="https://verify.iatsl.lk/" target="_blank">verify.iatsl.lk</a>
    </div>
    <div id="nic">
        <p>{{ $student->nic_no }}</p>
    </div>
    <div id="pass_rate">
        <p>"{{ $student->pass_rate }}"</p>
    </div>
    <div id="certificate_no">
        <p>Certificate No: {{ $student->certificate_no }}</p>
    </div>

</body>
</html>
