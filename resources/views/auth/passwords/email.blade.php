@extends('layouts.welcome_layout')

@section('content')
<div class="container passwords-email">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card border-0">
				<div class="card-header font-weight-bold">بازیابی رمز عبور</div>

				<div class="card-body">
					@if (session('status'))
							<div class="alert alert-success" role="alert">
									{{ session('status') }}
							</div>
					@endif

					<form method="POST" action="{{ route('password.email') }}" autocomplete="off">
						@csrf

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">آدرس ایمیل:</label>

							<div class="col-md-6">
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>

									@error('email')
											<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
											</span>
									@enderror
							</div>
						</div>

						<div class="form-group row justify-content-end mb-0">
							<div class="col-md-6 text-left">
								<button type="submit" class="btn btn-secondary mt-3">
									ارسال لینک تغییر رمز عبور
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
