<li class="list-group-item bg-transparent d-flex align-items-center mr-1 mr-md-5 pb-2 py-md-0">
	<form id="perPage-form">
		<div class="form-group my-0">
			
			{{-- Hidden input fields for keeping other query strings -- any better idea?? --}}
			{{ $slot }}

			<select 
				class="form-control-sm text-secondary border-0 perPage-select" 
				id="perPageSelect" name="perPage" onchange="this.form.submit()"
			>
				<option selected="true" disabled="disabled">فیلتر تعداد</option>
				@for ($count = 10; $count <= 50; $count += 10)
					<option 
						value="{{ $count }}" 
						{{ request()->get('perPage') == $count ? 'selected' : '' }}
					>
						{{ $count }}
					</option>
				@endfor
			</select>
		</div>
	</form>
</li>