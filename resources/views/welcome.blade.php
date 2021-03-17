<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zestlog</title>
    <link rel="icon" type="image/png" href="{{asset('assets/images/Chela One 2-1 Final.png')}}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css?id=').version()}}">
    <link rel="stylesheet" href="{{asset('css/custom.css?id=').version()}}">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>
    <!-- <div class="flex-center position-ref full-height">
       @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif 

        
    </div> -->

    <div class="home-wrapper" style="background-image: url('/assets/images/home-bg.png')">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-41 m-auto">
                    <div class="auth-wrapper">
                        <img src="{{asset('assets/images/Chela One 2-1 Final.png')}}" class="home-site-logo" alt="app-logo">

                        <h3 class="text-center fw-600 mb-3">Welcome to Zestlog</h3>
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            @if(Session::has('wrong_credentials'))
                                <p class="alert alert-danger">{{ Session::get('wrong_credentials') }}</p>
                            @endif
                            <div class="d-flex mb-2">
                                <span class="hp-label"><strong>+</strong></span>
                                <input type="text" size="3" style="width: 30%!important;" onkeypress="return isNumber(event)"  name="extension" id="extension" value="{{ old('extension') }}"  class="form-control mr-2 style__3 @error('extension') is-invalid @enderror" required />
                                <input type="mobile_number" onkeypress="return isNumber(event)" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control style__3 @error('mobile_number') is-invalid @enderror" placeholder="Mobile Phone" required />
                                @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
                                @enderror
                            </div>
                            <div class="mb-3" >

                                <input id="password" type="password" name="password"  class="password-hide form-control style__3 @error('password') is-invalid @enderror" placeholder="Password" required/>
                                <span class="fa fa-eye password-field"></span>
                                @error('password')
                                <span class="invalid-feedback "role="alert">
									<strong>{{ $message }}</strong>
								</span>
                                @enderror
                            </div>
                            <div class="text-right mb-3">
                                <a href="http://" class="text-primary fw-600" data-toggle="modal" data-target="#forgot-pass-modal">Forgot password</a>
                            </div>
                            <p class="text-muted text-center" data-toggle="modal" data-target="#hw-coach-modal" role="button"><small>How to become a Fitness Coach on Zestlog</small></p>

                            @if (Route::has('login'))
                                <button class="btn primary-btn btn-block mb-4">Log in</button>
                            @auth
                            @endif
                            @endauth


                            <p class="text-dark text-center">Not on Zestlog yet?</p>
                            <div class="text-center">
                                <a role="button" class="btn outline-btn" data-toggle="modal" data-target="#join-modal">Join</a>
                            </div>
                        </form>
                    </div>
                </div>
                @include('layouts.home-footer')
            </div>
        </div>
    </div>
    <!-- Forgot password modal -->
    <div class="modal fade" id="forgot-pass-modal" tabindex="-1" aria-labelledby="forgot-pass-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="hp-modal modal-content">
                <div class="modal-header border-0 p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-5">
                    <h3 class="fw-600 mb-4">Forgot your password?</h3>
                    <p class="text-dark mb-0 fw-600">Please use our mobile app to change your password.</p>
                    <span class="text-muted">You can find "Forgot Password" on the app login page.</span>
                </div>

            </div>
        </div>
    </div>

    <!-- Become a coach modal -->
    <div class="modal fade" id="hw-coach-modal" tabindex="-1" aria-labelledby="hw-coach-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="hp-modal modal-content">
                <div class="modal-header border-0 p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-5 px-4">
                    <h3 class="fw-600 mb-4">How to become a Fitness Coach on Zestlog</h3>
                    <p class="text-dark mb-0 fw-600">On your mobile.</p>
                    <ol>
                        <li class="text-muted">Download <a href="https://play.google.com/store/apps/details?id=com.imark.zestlog" target="_blank">Zestlog app</a> and create your Zestlog account <br> <small>(Currently only Android App is available)</small></li>
                        <li class="text-muted">Activate <a href="#!"> your coach channel</a> in your account setting</li>
                    </ol>

                    <p class="text-dark mb-0 fw-600">On the web <small class="fw-600">(at www.zestlog.com)</small></p>
                    <ol>
                        <li class="text-muted">Enter your phone number & password and press log in <br> <small>(same phone number & password as you use for our mobile app)</small></li>
                        
                    </ol>
                    
                </div>

            </div>
        </div>
    </div>

    <!-- Join modal -->
    <div class="modal fade" id="join-modal" tabindex="-1" aria-labelledby="join-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="hp-modal modal-content">
                <div class="modal-header border-0 p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-5">
                    <h3 class="fw-600 mb-4">Joining Zestlog community?</h3>
                    <p class="text-dark mb-0 fw-600">Please create your account on our mobile app.</p>
                    <span class="text-muted">Download <a target="_blank" href="https://play.google.com/store/apps/details?id=com.imark.zestlog">Zestlog app</a> and create your Zestlog account <br><small>(Currently only Android app is available)</small></span>
                </div>

            </div>
        </div>
    </div>
    @include('layouts.footer')
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    $(".password-field").click(function () {
        var input = $('.password-hide').attr("type");
        if (input == "password") {
            $('.password-hide').attr("type", 'text');
            $('.password-field').removeClass("fa-eye").addClass('fa-eye-slash');
        } else {
            $('.password-hide').attr("type", 'password');
            $('.password-field').removeClass("fa-eye-slash").addClass('fa-eye');
        }
    });
</script>
</html>
