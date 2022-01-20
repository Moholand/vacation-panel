@extends('layouts.base')

@section('content')
  <h4>همه‌ی درخواست‌ها</h4>
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
        @php
          // Calculate Local date
          Verta::setStringformat('H:i Y-n-j');
          $request_date = new Verta($vacation->updated_at);
        @endphp
        <div class="card mb-4">
          <div class="card-header py-2 px-4 d-flex justify-content-between align-items-center vacation-header" id="heading-{{ $key }}" data-toggle="collapse" data-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
            <div class="request-info d-flex justify-content-between align-items-center">
              <h6 class="mb-0 vacation-title">{{ $key + 1 }}) <span>عنوان:</span> {{ $vacation->title }} <span class="small font-weight-bold" dir="rtl">({{ $request_date }})</span></h6> 
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
                  <form action="{{ route('vacations.destroy', ['vacation' => $vacation->id]) }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button onclick="confirmation(event)" type="submit" id="delete-request" class="text-danger border-0 bg-transparent mr-2" title="حذف">
                      <i class="far fa-trash-alt fa-lg"></i>
                    </button>
                  </form>
                  <a href="{{ route('vacations.edit', ['vacation' => $vacation->id]) }}" class="text-info" title="ویرایش">
                    <i class="far fa-edit fa-lg"></i>
                  </a>
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
  </div>

  @include('includes.deleteModal')

@endsection

@push('scripts')
  <script>
    // Confirm delete vacation request
    function confirmation(e) {
      e.preventDefault();
      
      $('#confirmModal').modal('show');

      $('#confirmModal').on('shown.bs.modal', function(e) {
        $('#deleteBtn').on('click', function() {
          $('#deleteForm').submit();
        });
      })
    }
  </script>
@endpush