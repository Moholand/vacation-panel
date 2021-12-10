@extends('layouts.enter')

@section('content')
<div class="container login">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card border-0">
				<div class="card-header text-center p-4">
					<span class="font-weight-bold h5">ورود به پنل درخواست مرخصی</span>
				</div>

				<div class="card-body p-4">
					<form method="POST" action="{{ route('login') }}">
						@csrf

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">آدرس ایمیل:</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

								@error('email')
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right font-weight-bold">پسورد:</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row mb-0 mt-5">
							<div class="col-md-6">
								@if (Route::has('password.request'))
									<a class="btn btn-link text-decoration-none password-recovery" href="{{ route('password.request') }}">
										رمز عبور خود را فراموش کرده‌اید؟
									</a>
								@endif
							</div>
							<div class="col-md-6 text-left">
								<button type="submit" class="btn btn-primary">
									ورود
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
