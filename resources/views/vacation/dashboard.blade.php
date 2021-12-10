@extends('layouts.base')

@section('content')
  <h4>همه‌ی درخواست‌ها</h4>
  <hr>
  @if(session()->has('successMessage'))
    <div class="alert alert-success" role="alert">
      {{ session()->get('successMessage') }}
    </div>
  @endif

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
              <h5 class="mb-0 vacation-title">{{ $key + 1 }}) <span>عنوان:</span> {{ $vacation->title }} <span class="small font-weight-bold" dir="rtl">({{ $request_date }})</span></h5> 
              <div class="status font-weight-bold">
                <span>وضعیت:</span>
                <span class="mr-2 badge badge-{{ translate_status($vacation->status)['status_class'] }}">
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
                    <span class="mr-5 font-weight-bold">تا تاریخ:</span> <span>&#x200E;{{ $vacation->to_date }}</span>
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
              <div class="mb-0 d-flex align-items-center flex-row-reverse edit/delete">
                <form action="{{ route('vacations.destroy', ['vacation' => $vacation->id]) }}" method="POST" id="deleteForm">
                  @csrf
                  @method('DELETE')
                  <button onclick="confirmation(event)" type="submit" id="delete-request" class="text-danger border-0 bg-transparent mr-2" title="حذف">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                  </button>
                </form>
                <a href="{{ route('vacations.edit', ['vacation' => $vacation->id]) }}" class="text-info" title="ویرایش">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                  </svg>
                </a>
              </div>
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

  <!-- Modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-items-center">
          <h5 class="modal-title" id="confirmModalLabel">هشدار!!!</h5>
          <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          آیا مایل به حذف درخواست می‌باشید؟
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="deleteBtn">حذف درخواست</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
        </div>
      </div>
    </div>
  </div>

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