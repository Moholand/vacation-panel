@extends('layouts.main_layout')

@push('stylesheets')
  <link type="text/css" rel="stylesheet" href="{{ asset('css/jalalidatepicker.min.css') }}" />
@endpush

@section('filters')

  <x-per-page-filter>
    @if(request()->fromDate || request()->toDate || request()->vacation_status)
      <input type="hidden" name="fromDate" value="{{ request()->fromDate ?? null }}"/>
      <input type="hidden" name="toDate" value="{{ request()->toDate ?? null }}"/>
      <input type="hidden" name="vacation_status" value="{{ request()->vacation_status ?? null }}"/>
    @endif
  </x-per-page-filter>

  {{-- Doesn`t show vacation status filter on trashed page --}}
  @if(Route::is('vacations.index'))
    <x-status-filter :statuses="['submitted', 'initial-approval', 'confirmed', 'refuse']">
      @if(request()->fromDate || request()->toDate || request()->perPage)
        <input type="hidden" name="fromDate" value="{{ request()->fromDate ?? null }}"/>
        <input type="hidden" name="toDate" value="{{ request()->toDate ?? null }}"/>
        <input type="hidden" name="perPage" value="{{ request()->perPage ?? null }}"/>
      @endif
    </x-status-filter>
  @endif

  <x-date-filter>
    @if(request()->perPage || request()->vacation_status)
			<input type="hidden" name="perPage" value="{{ request()->perPage ?? null }}"/>
			<input type="hidden" name="vacation_status" value="{{ request()->vacation_status ?? null }}"/>
		@endif
  </x-date-filter>
  
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center">
    <h4>{{ Route::is('vacations.index') ? 'همه‌ی درخواست‌ها' :
     'زباله‌دان' }}</h4>
    
    @if(Route::is('vacations.index'))
      <a 
        href="{{ route('vacations.trashed') }}" 
        class="btn btn-outline-danger d-flex justify-content-between align-items-center"
      >
        <i class="fas fa-recycle"></i>
        <span class="mr-2 font-weight-bold">زباله‌دان</span>
      </a>
    @elseif(Route::is('vacations.trashed'))
      <a 
        href="{{ route('vacations.index') }}" 
        class="btn btn-outline-primary d-flex justify-content-between align-items-center"
      >
        <i class="fas fa-arrow-left"></i>
        <span class="mr-2 font-weight-bold">همه درخواست‌ها</span>
      </a>
    @endif
  </div>
  <hr class="mb-0">

  @include('includes.successMessage')

  @if(session()->has('errorMessage'))
    <div class="alert alert-danger" role="alert">
      {{ session()->get('errorMessage') }}
    </div>
  @endif

  <div class="request-list">
    <div id="accordion">
      @forelse($vacations as $key => $vacation)

        <div class="card mb-4">
          <div 
            class="card-header py-2 px-4 d-flex justify-content-between align-items-center vacation-header" 
            id="heading-{{ $key }}" 
            data-toggle="collapse" 
            data-target="#collapse-{{ $key }}"
          >

            <div class="request-info d-flex justify-content-between align-items-center">
              <h6 class="mb-0 vacation-title">
                {{ ($key + 1) + (($vacations->currentPage() - 1) * $vacations->perPage()) }})
                <span>عنوان:</span> 
                {{ $vacation->title }} 
                <span class="small font-weight-bold" dir="rtl">({{ $vacation->updated_at }})</span>
              </h6> 
              <div class="status font-weight-bold">
                <span>وضعیت:</span>
                <span class="mr-2 text-white badge badge-{{ translate_status($vacation->status)['status_class'] }}">
                  {{ translate_status($vacation->status)['status'] }}
                </span>
              </div>
            </div>

            <span class="btn btn-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
              </svg>
            </span>

          </div>
      
          <div id="collapse-{{ $key }}" class="collapse" aria-labelledby="heading-{{ $key }}" data-parent="#accordion">
            <div class="card-body">
              <span class="font-weight-bold">متن درخواست:</span>
              <p>{{ $vacation->request_message }}</p>
              <div class="row mb-3">
                <div class="col-md-4">
                  <span class="font-weight-bold">نوع مرخصی:</span> <span>{{ translate_type($vacation->type) }}</span>
                </div>
                <div class="col-md-4">
                  <span class="font-weight-bold">حالت مرخصی:</span> <span>{{ translate_mode($vacation->mode) }}</span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <span class="font-weight-bold">از تاریخ:</span> <span>&#x200E;{{ $vacation->from_date }}</span>
                  @if($vacation->mode === 'daily')
                    <span class="mr-4 mr-md-5 font-weight-bold">تا تاریخ:</span> <span>&#x200E;{{ $vacation->to_date }}</span>
                  @endif
                </div>
                @if($vacation->mode === 'hourly')
                <div class="col-md-4">
                  <span class="font-weight-bold">از ساعت:</span> <span>{{ $vacation->from_hour }}</span>
                  <span class="mr-5 font-weight-bold">تا ساعت:</span> <span>{{ $vacation->to_hour }}</span>
                </div>
                @endif
              </div>
              @if($vacation->response_message)
                <hr>
                <span class="font-weight-bold">متن پاسخ:</span>
                <p>{{ $vacation->response_message }}</p>
              @endif

              @if($vacation->status === 'submitted')
                <div class="mb-0 d-flex align-items-center flex-row-reverse edit/delete">
                  <form action="{{ route('vacations.destroy', $vacation) }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button onclick="confirmation(event)" type="submit" id="delete-request" class="text-danger border-0 bg-transparent mr-2" title="حذف">
                      <i class="far fa-trash-alt fa-lg"></i>
                    </button>
                  </form>

                  @if(Route::is('vacations.index'))
                    <a href="{{ route('vacations.edit', $vacation) }}" class="text-info" title="ویرایش">
                      <i class="far fa-edit fa-lg"></i>
                    </a>
                  @elseif(Route::is('vacations.trashed'))
                    <form action="{{ route('vacations.restore', $vacation) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="text-primary border-0 bg-transparent mr-2" title="بازیابی">
                        <i class="fas fa-undo fa-lg"></i>
                      </button>
                    </form>
                  @endif
                </div>
              @endif

            </div>
          </div>
        </div>
      @empty
        <div class="alert alert-danger p-4 text-center border-0 font-weight-bold">
          متأسفانه درخواستی یافت نشد !!!
        </div>
      @endforelse
    </div>

    {{ $vacations->onEachSide(2)->links('vendor.pagination.default') }}
  </div>

  <x-confirm-modal title="حذف درخواست مرخصی"></x-confirm-modal>
@endsection

@push('scripts')
  <script type="text/javascript" src="{{ asset('js/jalalidatepicker.min.js') }}"></script>
  <script>
    $( document ).ready(function() {
      // Date picker start
      jalaliDatepicker.startWatch();
    });

    // Confirm delete vacation request
    function confirmation(e) {
      e.preventDefault();

      let form = e.target.parentElement.parentElement;
      
      $('#confirmModal').modal('show');

      $('#confirmModal').on('shown.bs.modal', function(e) {
        $('#confirmBtn').on('click', function() {
          $(form).submit();
        });
      })
    }
  </script>
@endpush