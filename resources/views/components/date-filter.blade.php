<li class="list-group-item bg-transparent d-flex justify-content-center align-items-center date-filter pb-3 pt-2 py-md-4">
	<form autocomplete="off">
		{{-- Hidden input fields for keeping other query strings -- any better idea?? --}}
		{{$slot}}
		
		<div class="form-row">
			<div class="col-4">
				<input 
					type="text" 
					name="fromDate"
					class="form-control-sm border-0 from-date-input" 
					placeholder="تاریخ شروع"
					data-jdp
					value="{{ request()->get('fromDate') ?? '' }}"
					required
				>
			</div>
			<div class="col-4">
				<input 
					type="text" 
					name="toDate"
					class="form-control-sm border-0 to-date-input" 
					placeholder="تاریخ پایان"
					data-jdp
					value="{{ request()->get('toDate') ?? '' }}"
					required
				>
			</div>
			<div class="col-4">
				<button 
					type="submit" 
					class="btn btn-outline-secondary btn-sm"
				>
					اعمال فیلتر
				</button>
			</div>
		</div>
	</form>
</li>