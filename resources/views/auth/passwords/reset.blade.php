<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<title>Zestlog</title>

		<meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
		<meta name="author" content="pixelcave">
		<meta name="robots" content="noindex, nofollow">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

		<!-- Icons -->
		<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
		<link rel="shortcut icon" href="img/favicon.png">
		<link rel="icon" href="favicon.html" type="image/x-icon">
		<link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
		<link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
		<link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
		<link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
		<link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
		<link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
		<link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
		<link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">
		<!-- END Icons -->

		<!-- Stylesheets -->
		<!-- Bootstrap is included in its original form, unaltered -->
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

		<!-- Related styles of various icon packs and plugins -->
		<link rel="stylesheet" href="{{asset('css/plugins.css')}}">

		<!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
		<link rel="stylesheet" href="{{asset('css/main.css')}}">
		<link rel="stylesheet" href="{{asset('css/custom.css?id=').version()}}">

		<!-- Modernizr (browser feature detection library) -->
		<script src="{{asset('js/vendor/modernizr-3.3.1.min.js')}}"></script>
		
	</head>
	<body>
		<main class="account__warper">
			<div class="account__center__wraper">
				<div class="account__logo">
					<a href="index.html"><img src="{{asset('assets/images/logo.png')}}" alt="logo.png" /></a>
				</div>
				<div class="account__content__wraper">
					<div class="title">
						<h2>Reset Password</h2>
					</div>
					
					<form method="POST" action="{{ route('password.update') }}">
					@csrf			
						<input type="hidden" name="token" value="{{ $token }}">
						<p class="small__font callout small al__0 at__100" id="messageHelpText"></p>
						<div class="form-group form-row">
							<label class="col-md-4 label__title">E-Mail Address:</label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control style__3 @error('email') is-invalid @enderror" placeholder="Email" required />
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
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
									<div class="input-group-prepend">
										<a href="#" class="input-group-text fa-eyes" title="show password"><i class="fa fa-eye" aria-hidden="true"></i></a>
									</div>
								</div>
								<p class="small__font callout small al__0 at__100" id="confirmPasswordHelpText" ></p>
							</div>
						</div>

						<div class="form-group text-right">
							<button class="btn btn-default">Reset Password</button>
						</div>

					</form>
				</div>
			</div>
		</main>
	</body>
</html> 
