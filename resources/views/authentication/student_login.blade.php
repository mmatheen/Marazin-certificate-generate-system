<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ URL::to('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="assets/plugins/toastr/toatr.css">
    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
</head>

<body>
    <style>
        .invalid-feedback {
            font-size: 14px;
        }
    </style>

     {{-- for sound --}}
     <audio class="successSound" src="{{ URL::to('assets/sounds/success.mp3') }}"></audio>
     <audio class="errorSound" src="{{ URL::to('assets/sounds/error.mp3') }}"></audio>


    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="{{ URL::to('assets/img/login.png') }}" alt="Logo">
                    </div>

                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1 class="mb-4">Welcome to Marazin login</h1>
                            <form action="{{ route('student/login/check') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>NIC<span class="login-danger">*</span></label>
                                    <input type="text" class="form-control @error('nic_no') is-invalid @enderror" name="nic_no">

                                </div>
                                <div class="form-group">
                                    <label>Registration No<span class="login-danger">*</span></label>
                                    <input type="text" class="form-control @error('registration_no') is-invalid @enderror" name="registration_no">

                                </div>

                                <div class="forgotpass">
                                    <div class="remember-me">
                                        <label class="custom_check mr-2 mb-0 d-inline-flex remember-me"> Remember me
                                            <input type="checkbox" name="remember">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <a href="#">Forgot Password?</a>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>
                                </form>
                            {{-- <div class="login-or">
                                <span class="or-line"></span>
                                <span class="span-or">or</span>
                            </div> --}}
                            {{-- <div class="social-login">
                                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::to('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/feather.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/toastr/toastr.js') }}"></script>
    <script src="{{ URL::to('assets/js/script.js') }}"></script>

    <script>
        $(document).ready(function() {
            var successSound = document.querySelector('.successSound');
            var errorSound = document.querySelector('.errorSound');

            @if(Session::has('toastr-success'))
                toastr.success("{{ Session::get('toastr-success') }}");
                successSound.play();
            @endif

            @if(Session::has('toastr-error'))
                toastr.error("{{ Session::get('toastr-error') }}");
                errorSound.play();
            @endif

            @if(Session::has('toastr-warning'))
                toastr.warning("{{ Session::get('toastr-warning') }}");
            @endif

            @if(Session::has('toastr-info'))
                toastr.info("{{ Session::get('toastr-info') }}");
            @endif
        });
    </script>

</body>

</html>
