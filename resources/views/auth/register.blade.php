@extends('layouts.auth')
<body>
	
<main class="account__warper">
	<div class="account__center__wraper">
		<div class="account__logo">
			<a href="index.html"><img src="{{asset('assets/images/logo.png')}}" alt="logo.png" /></a>
		</div>
		<div class="account__content__wraper">
				<h3 class="section-title">sign up</h3>
            
			<form method="POST" action="{{ route ('register') }}" id="registerForm">
            @csrf			
                <p class="small__font callout small al__0 at__100" id="messageHelpText"></p>
				<div class="form-group form-row">
					<label class="col-md-4 label__title">First Name:</label>
					<div class="col-md-8">
						<div class="input-group">
							<input type="text" name="first_name" value="{{ old('first_name') }}"  autocomplete="First Name"  class="form-control style__3 @error('first_name') is-invalid @enderror" placeholder="First name" required />
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
                        <p class="small__font callout small al__0 at__100" id="firstnameHelpText"></p>
                        
					</div>
				</div>

				<div class="form-group form-row">
					<label class="col-md-4 label__title">Last Name:</label>
					<div class="col-md-8">
						<div class="input-group">
                            <input type="text" name="last_name" value="{{ old('last_name') }}"  autocomplete="last name"  class="form-control style__3 @error('last_name') is-invalid @enderror" placeholder="Last Name" required />
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<p class="small__font callout small al__0 at__100" id="lastnameHelpText"></p>
                    </div>
                    
				</div>

				<div class="form-group form-row">
					<label class="col-md-4 label__title">Username:</label>
					<div class="col-md-8">
						<div class="input-group">
                            <input type="text" name="user_name" value="{{ old('user_name') }}"  autocomplete="User Name"  class="form-control style__3 @error('user_name') is-invalid @enderror" placeholder="User Name" required />
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            @error('user_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<p class="small__font callout small al__0 at__100" id="usernameHelpText"></p>
					</div>
				</div>

				<div class="form-group form-row align-items-start mb-4">
					<label class="col-md-4 label__title">Mobile Number:</label>
					<div class="col-md-8">
						<div class="form-row align-items-start relative">
							<div class="col-3 d-flex align-items-center">
								<span class="text mr-1">+</span>
								<input type="text" name="country_code" value="1" class="form-control style__3 " placeholder="47" />
							</div>
							<div class="col-9">
								<div class="input-group">
                                    <input type="number" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control style__3 @error('mobile_number') is-invalid @enderror" placeholder="123456" required />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    </div>
                                    @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
								</div>
							</div>
							<p class="small__font absolute al__0 at__100 mb-0 mt-2">
								{{--<small>We will text you a verification code</small></p>--}}
						</div>
						<p class="small__font callout small al__0 at__100 mb-0" id="phoneHelpText"></p>
					</div>
				</div>

				<div class="form-group form-row">
					<label class="col-md-4 label__title">Email:</label>
					<div class="col-md-8">
						<div class="input-group">
							<input type="email" name="email" value="{{ old('email') }}" class="form-control style__3 @error('email') is-invalid @enderror" placeholder="" required />
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
                        <p class="small__font callout small al__0 at__100" id="emailHelpText"></p>
                    </div>
				</div>

				<div class="form-group form-row">
					<label class="col-md-4 label__title">Password:</label>
					<div class="col-md-8">
						<div class="input-group">
							<input id="password" type="password" name="password" class="form-control style__3 @error('password') is-invalid @enderror" placeholder="Password"  required />
							<div class="input-group-prepend">
								<a href="#" class="input-group-text fa-eyes" title="show password"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<p class="small__font callout small al__0 at__100" id="passwordHelpText"></p>
                    </div>
                    
				</div>

				<div class="form-group form-row">
					<label class="col-md-4 label__title">Confirm Password:</label>
					<div class="col-md-8">
						<div class="input-group">
							<input id="password-confirm" type="password" name="password_confirmation"  class="form-control style__3 " aria-describedby="confirmPasswordHelpText" placeholder="Verify Password" autocomplete="new-password" required />
							<div class="input-group-prepend">
								<a href="#" class="input-group-text fa-eyes" title="show password"><i class="fa fa-eye" aria-hidden="true"></i></a>
							</div>
						</div>
						<p class="small__font callout small al__0 at__100" id="confirmPasswordHelpText" ></p>
					</div>
				</div>

				<div class="form-group text-right">
					<button class="btn primary-btn">Signup</button>
				</div>

			</form>
		</div>
	</div>
</main>
<!--footer-copyright-end--> 

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<!-- <script src="js/jquery-2.2.4.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.js"></script> -->
	<!-- <script src="https://zestlog.customer-devreview.com/js/custom.js"></script> -->
	<script>
	

	$("body").on("click", "a.fa-eyes", function(e) {
		e.preventDefault();
		$(this).parents('.input-group').find('input').attr('type', 'text');
		$(this).addClass('fa-eyes-slash');
		$(this).attr('title', 'hide password');
		$(this).find('i').addClass('fa-eye-slash');
		$(this).find('i').removeClass('fa-eye');
		$(this).removeClass('fa-eyes');
	});
	$("body").on("click", "a.fa-eyes-slash", function(e) {
		e.preventDefault();
		$(this).parents('.input-group').find('input').attr('type', 'password');
		$(this).removeClass('fa-eyes-slash');
		$(this).attr('title', 'show password');
		$(this).find('i').removeClass('fa-eye-slash');
		$(this).find('i').addClass('fa-eye');
		$(this).addClass('fa-eyes');
	});
</script>
</body>
