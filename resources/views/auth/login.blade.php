@extends('layouts.auth')
<body>
	<main class="account__warper">
		<div class="account__center__wraper">
			<div class="account__logo">
				<a href="index.html"><img src="{{asset('assets/images/logo.png')}}" alt="logo.png" /></a>
			</div>
			<div class="account__content__wraper">
				<h3 class="section-title">Login</h3>

				<form method="POST" action="{{ route('login') }}">
					@csrf
					<p class="small__font callout small al__0 at__100" id="messageHelpText"></p>
					<div class="form-group form-row">
						<label class="col-md-4 label__title">Email:</label>
						<div class="col-md-8">
							<div class="input-group">
								<input type="email" name="email" value="{{ old('email') }}" class="form-control style__3 @error('email') is-invalid @enderror" placeholder="Email" required />
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
								<input id="password" type="password" name="password" class="form-control style__3 @error('password') is-invalid @enderror" placeholder="Password" required />
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
						<div class="col-md-8 ml-auto">
							<div class="remember-chb custom-control custom-checkbox pl-0">
								<input type="checkbox" class="form-check-input 	custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
								<label class="custom-control-label" for="remember"><small>Remember Me</small></label>
							</div>
							<p class="small__font callout small al__0 at__100" id="confirmPasswordHelpText"></p>
						</div>
					</div>

					<div class="form-group text-right">
						<button class="btn primary-btn">Login</button>
						@if (Route::has('password.request'))
						<a class="btn outline-btn" href="{{ route('password.request') }}">
							Forgot Your Password
						</a>
						@endif
					</div>

				</form>
			</div>
		</div>
	</main>
</body>
