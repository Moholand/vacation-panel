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

  <x-status-filter :statuses="['initial-approval', 'confirmed', 'refuse']">
    @if(request()->fromDate || request()->toDate || request()->perPage)
      <input type="hidden" name="fromDate" value="{{ request()->fromDate ?? null }}"/>
      <input type="hidden" name="toDate" value="{{ request()->toDate ?? null }}"/>
      <input type="hidden" name="perPage" value="{{ request()->perPage ?? null }}"/>
    @endif
  </x-status-filter>

  <x-date-filter>
    @if(request()->perPage || request()->vacation_status)
      <input type="hidden" name="perPage" value="{{ request()->perPage ?? null }}"/>
      <input type="hidden" name="vacation_status" value="{{ request()->vacation_status ?? null }}"/>
    @endif
  </x-date-filter>

@endsection

@section('content')
  <h4>همه‌ی درخواست‌ها</h4>
  <hr class="mb-0 header-line">

  @include('includes.successMessage')

  <div class="request-list">
    <div id="accordion">
      @forelse($vacations as $key => $vacation)

        <div class="card mb-4">
          <div class="card-header py-2 px-4 d-flex justify-content-between align-items-center vacation-header" 
            id="heading-{{ $key }}" 
            data-toggle="collapse" 
            data-target="#collapse-{{ $key }}"
          >

            <div class="request-info d-flex justify-content-between align-items-center">
              <h6 class="mb-0 vacation-title">
                {{ ($key + 1) + (($vacations->currentPage() - 1) * $vacations->perPage()) }}) 
                <span>نام:</span> 
                {{ $vacation->user->name }} 
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
              <span class="font-weight-bold">عنوان درخواست:</span>
              <p>{{ $vacation->title }}</p>
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
              <div class="row mr-0">
                <div class="com-md-4">
                  <span class="font-weight-bold">از تاریخ:</span> <span>&#x200E;{{ $vacation->from_date }}</span>
                  @if($vacation->mode === 'daily')
                    <span class="font-weight-bold mr-5">تا تاریخ:</span> <span>&#x200E;{{ $vacation->to_date }}</span>
                  @endif
                </div>
                @if($vacation->mode === 'hourly')
                <div class="col-md-4">
                  <span class="font-weight-bold">از ساعت:</span> <span>{{ $vacation->from_hour }}</span>
                  <span class="mr-5 font-weight-bold">تا ساعت:</span> <span>{{ $vacation->to_hour }}</span>
                </div>
                @endif
              </div>
              {{-- Only vacations with status of 'initial-approval' can be updated by admin  --}}
              {{-- 'initial-approval' => Means vacations that confirmed by head of department --}}
              @if($vacation->status === 'initial-approval')
                <hr>
                <form action="{{ route('admin.vacations.update', $vacation) }}" method="POST" id="vacationUpdateForm">
                  @csrf
                  @method('PATCH')

                  <input type="hidden" name="verification">

                  <div class="form-group">
                    <label for="response_message" class="font-weight-bold">متن پاسخ:</label>
                    <textarea class="form-control" name="response_message" id="response_message" cols="15" rows="3" placeholder="متن پاسخ"></textarea>
                  </div>
                  
                  <div class="form-group mb-0 d-flex justify-content-end">
                    <button 
                      onclick="confirmation(event, 'confirmed')" 
                      type="submit" name="confirmed" value="confirmed" class="btn btn-sm btn-success"
                    >
                      تأیید
                    </button>
                    <button
                      onclick="confirmation(event, 'refuse')" 
                      type="submit" name="refuse" value="refuse" class="btn btn-sm btn-danger mr-2">
                      عدم تأیید
                    </button>
                  </div>

                </form>
              @else
                @if($vacation->response_message)
                  <hr>
                  <span class="font-weight-bold">متن پاسخ:</span>
                  <p>{{ $vacation->response_message }}</p>
                @endif
              @endif
            </div>
          </div>
        </div>

      @empty
        <div class="alert alert-danger p-4 text-center border-0 font-weight-bold">
          متأسفانه درخواستی یافت نشد !!!
        </div>
      @endforelse

      {{ $vacations->onEachSide(2)->links('vendor.pagination.default') }}

    </div>
  </div>

  <x-confirm-modal title="تأیید درخواست کاربر"></x-confirm-modal>
@endsection

@push('scripts')
  <script type="text/javascript" src="{{ asset('js/jalalidatepicker.min.js') }}"></script>
  <script>
    $( document ).ready(function() {
      // Date picker start
      jalaliDatepicker.startWatch();
    });

    function confirmation(e, status) {
      e.preventDefault();

      let form = e.target.parentElement.parentElement;

      $("#vacationUpdateForm input[name='verification']").val(status);

      if(status === 'refuse') {
        $("#confirmModal .confirm-modal-title").html("عدم تأیید درخواست کاربر"); 
      } else {
        $("#confirmModal .confirm-modal-title").html("تأیید درخواست کاربر"); 
      }
      
      $('#confirmModal').modal('show');

      $('#confirmModal').on('shown.bs.modal', function(e) {
        $('#confirmBtn').on('click', function() {
          $(form).submit();
        });
      })
    }
  </script>
@endpush
