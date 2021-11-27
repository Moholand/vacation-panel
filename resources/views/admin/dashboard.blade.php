@extends('layouts.base')

@section('content')
  <h4>همه‌ی درخواست‌ها</h4>
  @if(session()->has('successMessage'))
    <div class="alert alert-success" role="alert">
      {{ session()->get('successMessage') }}
    </div>
  @endif
  <div class="request-list mt-5">
    <div id="accordion">
      @foreach($vacations as $key => $vacation)
        <div class="card mb-3">
          <div class="card-header d-flex justify-content-between align-items-center vacation-header" id="heading-{{ $key }}" data-toggle="collapse" data-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
            <div class="request-info d-flex justify-content-between align-items-center">
              <h5 class="mb-0 vacation-title">{{ $key + 1 }}) {{ $vacation->user->name }}</h5>
              <div class="status">
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
              <p>
                <span class="font-weight-bold">از تاریخ:</span> <span>&#x200E;{{ $vacation->from_date }}</span>
                <span class="font-weight-bold mr-5">تا تاریخ:</span> <span>&#x200E;{{ $vacation->to_date }}</span>
              </p>
              <hr>
              <form action="{{ route('admin.vacations.store', ['vacation' => $vacation->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="response_message" class="font-weight-bold">متن پاسخ:</label>
                  <textarea class="form-control" name="response_message" id="response_message" cols="30" rows="5" placeholder="متن پاسخ">{{ $vacation->response_message }}</textarea>
                </div>
                <div class="form-group d-flex align-items-center change-status">
                  <label for="status" class="font-weight-bold mb-0">تغییر وضعیت:</label>
                  <select name="status" id="status" class="form-control">
                    <option value="submitted" {{ ($vacation->status) == 'submitted' ? 'selected' : '' }}>ارسال شده</option>
                    <option value="confirmed" {{ ($vacation->status) == 'confirmed' ? 'selected' : '' }}>تأیید</option>
                    <option value="refuse" {{ ($vacation->status) == 'refuse' ? 'selected' : '' }}>عدم تأیید</option>
                  </select>
                </div>
                <div class="form-group text-left">
                  <input type="submit" class="btn btn-success" value="اعمال تغییرات">
                </div>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection