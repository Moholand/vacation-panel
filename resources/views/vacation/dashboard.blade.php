@extends('layouts.base')

@section('content')
  <h4>همه‌ی درخواست‌ها</h4>
  <div class="request-list mt-5">
    <div id="accordion">
      @foreach($vacations as $key => $vacation)
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center" id="heading-{{ $key }}">
            <div class="request-info d-flex justify-content-between align-items-center">
              <h5 class="mb-0">{{ $vacation->title }}</h5>
              <div class="mr-5">
                @php
                  switch($vacation->status) {
                    case('confirmed'):
                      $status = 'تأیید';
                      $status_class = 'success';
                      break;
                    case('refuse'):
                      $status = 'عدم تأیید';
                      $status_class = 'danger';
                      break;
                    default:
                      $status = 'ارسال شده';
                      $status_class = 'info';
                  }
                @endphp
                <span>وضعیت:</span>
                <span class="mr-2 badge badge-{{ $status_class }}">
                  {{ $status }}
                </span>
              </div>
            </div>
            <span class="btn btn-link" data-toggle="collapse" data-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
              </svg>
            </span>
          </div>
      
          <div id="collapse-{{ $key }}" class="collapse" aria-labelledby="heading-{{ $key }}" data-parent="#accordion">
            <div class="card-body">
              <span class="font-weight-bold">متن درخواست:</span>
              <p>{{ $vacation->request_message }}</p>
              @if($vacation->response_message)
                <hr>
                <span class="font-weight-bold">متن پاسخ:</span>
                <p>{{ $vacation->response_message }}</p>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection