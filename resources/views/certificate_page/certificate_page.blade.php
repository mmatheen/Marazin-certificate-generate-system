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
                            <div class="user-text">
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->name_with_initial;}}</h6>
                                <p class="text-muted mb-0">Student</p>
                            </div>
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="user-text">
                                <h6>{{$name_with_initial = auth()->guard('student')->user()->name_with_initial;}}</h6>
                                <p class="text-muted mb-0">Student</p>
                            </div>
                        </div>
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
                                <button class="btn btn-success">Download</button>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Please Download Your Certificate</h5>
                            </div>
                            <div class="card-body">
                                <form action="#">
                                    <h6>{{$name_with_initial = auth()->guard('student')->user()->register_date;}}</h6>
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
                                    <h6>{{$name_with_initial = auth()->guard('student')->user()->batch_id;}}</h6>
                                </form>
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
