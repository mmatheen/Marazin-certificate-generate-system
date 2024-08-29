<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Preskool - Basic Inputs</title>

    <link rel="shortcut icon" href="assets/img/favicon.png">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/feather/feather.css">

    <link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        #certificate {
            background-image: url("assets/certificate-images/certificate-template.png");
            background-repeat: no-repeat;
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
            top: 46%;
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

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left">
                <a href="index.html" class="logo">
                    <img src="assets/img/logo.png" alt="Logo">
                </a>
                <a href="index.html" class="logo logo-small">
                    <img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
                </a>
            </div>


            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item dropdown has-arrow new-user-menus">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="assets/img/profiles/avatar-01.jpg" width="31"
                            alt="Soeng Souy">
                            <div class="user-text">
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->name_with_initial;}}</h6>
                                <p class="text-muted mb-0">Student</p>
                            </div>
                        </span>
                    </a>
                    <div class="dropdown-menu">

                        <a class="dropdown-item" href="{{ route('student/logout') }}">Logout</a>
                    </div>

                </li>

            </ul>

        </div>


        <div class="content container mt-5">
            <div class="page-header mt-5">
                <div class="row">
                    <div class="col mt-5">
                        <ul class="breadcrumb">

                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="m-4 d-flex justify-content-between">
                            <h5 class="card-title">Please Download Your Certificate</h5>
                            <a class="btn btn-outline-success" href="{{ route('certificate-pdf') }}" role="button"><i class="fas fa-cloud-download-alt"></i> Download</a>
                        </div>
                        <div class="card-body mb-5" id="certificate">

                        </div>
                        <div id="studentName">
                            <p>{{ $student->full_name_of_student }}</p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body mt-3">

                             <p>Registration Date: {{ $student->register_date }}</p>
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
                                <p>Batch No: {{ $student->batch->batch_no }}</p>

                                {{-- <h6>{{$name_with_initial = auth()->guard('student')->user()->register_date;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->effective_date_of_certificate;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->registration_no;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->reference_no;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->certificate_no;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->full_name_of_student;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->name_with_initial;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->nic_no;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->address;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->course_name;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->year;}}</h6>
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->batch_id;}}</h6> --}}

                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="card">

                        <div class="card-body">

                                <p>Registration Date: {{ $student->register_date }}</p>
                                <p>Effective Date of Certificate{{ $student->effective_date_of_certificate }}</p>
                                <p>Full Name of Student{{ $student->full_name_of_student }}</p>
                                <p>Reference No{{ $student->reference_no }}</p>
                                <p>Name With Initial {{ $student->name_with_initial }}</p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="card">

                        <div class="card-body">
                                <p>Registration Date: {{ $student->register_date }}</p>
                                <p>Effective Date of Certificate{{ $student->effective_date_of_certificate }}</p>
                                <p>Full Name of Student{{ $student->full_name_of_student }}</p>
                                <p>Reference No{{ $student->reference_no }}</p>
                                <p>Name With Initial {{ $student->name_with_initial }}</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <footer>
            <p>Copyright © 2022 Dreamguys.</p>
        </footer>



    </div>


    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>
</html>

