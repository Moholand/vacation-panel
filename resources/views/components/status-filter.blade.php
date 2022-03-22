<li class="list-group-item bg-transparent d-flex align-items-center pb-2 py-md-0">
	<form>
		<div class="form-group my-0">

			{{-- Hidden input fields for keeping other query strings -- any better idea?? --}}
			{{ $slot }}

			<select class="form-control-sm text-secondary border-0" name="vacation_status" onchange="this.form.submit()">
				<option selected="true" disabled="disabled">فیلتر وضعیت</option>
				<option value="">همه‌ی درخواست‌ها</option>
				@foreach($statuses as $status)
					<option value="{{ $status }}" {{ request()->get('vacation_status') === $status ? "selected" : "" }}>
						{{ __("words.{$status}"); }}
					</option>
				@endforeach
			</select>
		</div>
	</form>
</li>