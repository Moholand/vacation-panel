@extends('layouts.welcome_layout')

@section('content')
<div class="container register">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card border-0">
				<div class="card-header text-center p-4">   
					<span class="font-weight-bold h5">نام نویسی</span> 
				</div>

				<div class="card-body">
					<form method="POST" action="{{ route('register') }}">
						@csrf

						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right font-weight-bold">نام:</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

								@error('name')
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">آدرس ایمیل:</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

								@error('email')
										<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
										</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="department_id" class="col-md-4 col-form-label text-md-right font-weight-bold">واحد کاری:</label>

							<div class="col-md-6">
								{{-- <input id="department_id" type="text" class="form-control @error('department_id') is-invalid @enderror" name="department_id" value="{{ old('department_id') }}" required autocomplete="department_id"> --}}
								<select 
									name="department_id" 
									id="department_id" 
									class="form-control @error('department_id') is-invalid @enderror" 
									value="{{ old('department_id') }}" 
									required
								>
									<option selected="true" disabled="disabled">انتخاب واحد کاری</option>
									@foreach($departments as $department)
										<option value="{{ $department->id }}">{{ $department->name }}</option>
									@endforeach
								</select>

								@error('department_id')
										<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
										</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right font-weight-bold">رمز عبور:</label>

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
							<label for="password-confirm" class="col-md-4 col-form-label text-md-right font-weight-bold">تأیید رمز عبور</label>

							<div class="col-md-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
							</div>
						</div>

						<div class="form-group row flex-row-reverse mb-0">
							<div class="col-md-6 text-left">
								<button type="submit" class="btn btn-primary">
									ثبت نام
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
