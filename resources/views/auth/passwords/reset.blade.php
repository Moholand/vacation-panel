@extends('layouts.welcome_layout')

@section('content')
<div class="container passwords-reset">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card border-0">
				<div class="card-header font-weight-bold">تغییر رمز عبور</div>

				<div class="card-body">
					<form method="POST" action="{{ route('password.update') }}">
						@csrf

						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label font-weight-bold text-md-right">آدرس ایمیل:</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label font-weight-bold text-md-right">پسورد:</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="password-confirm" class="col-md-4 col-form-label font-weight-bold text-md-right">تأیید رمز عبور:</label>

							<div class="col-md-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
							</div>
						</div>

						<div class="form-group row justify-content-end mb-0">
							<div class="col-md-6 text-left">
								<button type="submit" class="btn btn-secondary">
									تغییر رمز عبور
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
