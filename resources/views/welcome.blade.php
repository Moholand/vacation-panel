<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>پنل درخواست مرخصی</title>
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	</head>
	<body class="welcome-page">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse pr-5" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link" href="{{ route('login') }}">ورود به پنل</a>
					<a class="nav-item nav-link mr-3" href="{{ route('register') }}">نام‌نویسی</a>
				</div>
			</div>
			<div class="navbar-nav">
				<a class="nav-item nav-link pl-5 mr-auto" href="{{ route('dashboard') }}">ورود به سایت</a>
			</div>
		</nav>
	</body>
</html>
