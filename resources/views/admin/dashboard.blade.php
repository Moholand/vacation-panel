@extends('layouts.main_layout')

@push('stylesheets')
  <link type="text/css" rel="stylesheet" href="{{ asset('css/jalalidatepicker.min.css') }}" />
@endpush

@section('filters')
  {{-- PerPage options --}}
  <li class="list-group-item bg-transparent d-flex align-items-center mr-1 mr-md-5 py-4">
    <form id="perPage-form">
      <div class="form-group my-0">
        {{-- Hidden input fields for keeping other query strings -- any better idea?? --}}
        @if(request()->fromDate || request()->toDate || request()->vacation_status)
          <input type="hidden" name="fromDate" value="{{ request()->fromDate ?? null }}"/>
          <input type="hidden" name="toDate" value="{{ request()->toDate ?? null }}"/>
          <input type="hidden" name="vacation_status" value="{{ request()->vacation_status ?? null }}"/>
        @endif
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

  {{-- Select Vacation status --}}
  <li class="list-group-item bg-transparent d-flex align-items-center py-2 py-md-4">
    <form>
      <div class="form-group my-0">

        {{-- Hidden input fields for keeping other query strings -- any better idea?? --}}
        @if(request()->fromDate || request()->toDate || request()->perPage)
          <input type="hidden" name="fromDate" value="{{ request()->fromDate ?? null }}"/>
          <input type="hidden" name="toDate" value="{{ request()->toDate ?? null }}"/>
          <input type="hidden" name="perPage" value="{{ request()->perPage ?? null }}"/>
        @endif

        <select class="form-control-sm text-secondary border-0" name="vacation_status" onchange="this.form.submit()">
          <option value="">همه‌ی درخواست‌ها</option>
          <option value="initial-approval" {{ request()->get('vacation_status') === 'initial-approval' ? 'selected' : '' }}>
            تأیید اولیه
          </option>
          <option value="confirmed" {{ request()->get('vacation_status') === 'confirmed' ? 'selected' : '' }}>
            تأیید نهایی
          </option>
          <option value="refuse" {{ request()->get('vacation_status') === 'refuse' ? 'selected' : '' }}>
            عدم تأیید
          </option>
        </select>
      </div>
    </form>
  </li>

  {{-- Date Range options --}}
  <li class="list-group-item bg-transparent d-flex align-items-center date-filter py-4">
    <form autocomplete="off">
      {{-- Hidden input fields for keeping other query strings -- any better idea?? --}}
      @if(request()->perPage || request()->vacation_status)
        <input type="hidden" name="perPage" value="{{ request()->perPage ?? null }}"/>
        <input type="hidden" name="vacation_status" value="{{ request()->vacation_status ?? null }}"/>
      @endif
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
          <button type="submit" class="btn btn-outline-secondary btn-sm">اعمال فیلتر</button>
        </div>
      </div>
    </form>
  </li>
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
                <form action="{{ route('admin.vacations.update', ['vacation' => $vacation->id]) }}" method="POST">
                  @csrf
                  @method('PATCH')

                  <div class="form-group">
                    <label for="response_message" class="font-weight-bold">متن پاسخ:</label>
                    <textarea class="form-control" name="response_message" id="response_message" cols="15" rows="3" placeholder="متن پاسخ">{{ $vacation->response_message }}</textarea>
                  </div>
                  
                  <div class="form-group mb-0 d-flex justify-content-end">
                    <button type="submit" name="submit" value="confirm" class="btn btn-sm btn-success">
                      تأیید
                    </button>
                    <button type="submit" name="submit" value="refuse" class="btn btn-sm btn-danger mr-2">
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
@endsection

@push('scripts')
  <script type="text/javascript" src="{{ asset('js/jalalidatepicker.min.js') }}"></script>
  <script>
    $( document ).ready(function() {
      // Date picker start
      jalaliDatepicker.startWatch();
    });
  </script>
@endpush
