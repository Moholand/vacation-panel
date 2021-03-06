@extends('layouts.main_layout')

@section('filters')

  <x-per-page-filter>
    @if(request()->department_id || request()->user_status)
      <input type="hidden" name="department_id" value="{{ request()->department_id ?? null }}"/>
      <input type="hidden" name="user_status" value="{{ request()->user_status ?? null }}"/>
    @endif
  </x-per-page-filter>

  {{-- Select Department --}}
  <li class="list-group-item bg-transparent d-flex align-items-center mr-1 mr-md-5 py-2 py-md-0">
    <form>
      <div class="form-group my-0">
        {{-- Hidden input fields for keeping other query strings -- any better idea?? --}}
        @if(request()->user_status || request()->perPage)
          <input type="hidden" name="user_status" value="{{ request()->user_status }}"/>
          <input type="hidden" name="perPage" value="{{ request()->perPage }}"/>
        @endif
        <select class="form-control-sm text-secondary border-0" name="department_id" onchange="this.form.submit()">
          <option selected="true" value="">همه‌ی واحدهای کاری</option>
          @foreach($departments as $department)
            <option 
              value="{{ $department->id }}" 
              {{ request()->get('department_id') == $department->id ? 'selected' : '' }}
            >
              {{ $department->name }}
            </option>
          @endforeach
        </select>
      </div>
    </form>
  </li>

  {{-- Select User status --}}
  <li class="list-group-item bg-transparent d-flex align-items-center mr-1 mr-md-5 py-2 py-md-0">
    <form>
      <div class="form-group my-0">
        {{-- Hidden input fields for keeping other query strings -- any better idea?? --}}
        @if(request()->department_id || request()->perPage)
          <input type="hidden" name="department_id" value="{{ request()->department_id }}"/>
          <input type="hidden" name="perPage" value="{{ request()->perPage }}"/>
        @endif
        <select class="form-control-sm text-secondary border-0" name="user_status" onchange="this.form.submit()">
          <option value="">همه‌ی کاربر‌ها</option>
          <option value="confirm" {{ request()->get('user_status') == 'confirm' ? 'selected' : '' }}>
            احراز هویت شده
          </option>
          <option value="refuse" {{ request()->get('user_status') == 'refuse' ? 'selected' : '' }}>
            عدم احراز هویت
          </option>
        </select>
      </div>
    </form>
  </li>

@endsection

@section('content')
  <h4>همه‌ی کاربرها</h4>
  <hr class="mb-0 header-line">

  @include('includes.successMessage')

  <div class="users-list pb-5">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">تصویر</th>
          <th scope="col">نام ‌و ‌نام‌خوانوادگی</th>
          <th scope="col">آدرس ایمیل</th>
          <th scope="col">واحد کاری</th>
          <th scope="col">احراز هویت</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($employees as $key => $employe)
          <tr>
            <th scope="row">{{ ($key + 1) + (($employees->currentPage() - 1) * $employees->perPage()) }}</th>
            <td>
              <img 
                src="{{ $employe->getAvatarPath($employe->avatar) }}" 
                alt="{{ $employe->name }}" class="rounded-circle" width="50"
              >
            </td>
            <td>{{ $employe->name }}</td>
            <td>{{ $employe->email }}</td>
            <td>{{ $employe->department->name ?? 'نامشخص' }}</td>
            <td>
              <form action="{{ route('admin.users.update', $employe) }}" method="POST" id="userUpdateForm">
                @csrf
                @method("PATCH")
                
                <input type="hidden" name="verification">

                <button 
                  type="submit" 
                  name="verified" 
                  value="verified" 
                  class="border-0 bg-transparent {{ $employe->isVerified ? 'text-success' : 'text-secondary' }}" 
                  title="تأیید"
                  onclick="confirmation(event, 'verified')"
                >
                  <i class="fas fa-user-check fa-lg"></i>
                </button>

                <button 
                  type="submit" 
                  name="verified" 
                  value="unverified" 
                  class="border-0 bg-transparent {{ $employe->isVerified ? 'text-secondary' : 'text-danger' }} mr-1" 
                  title="عدم تأیید"
                  onclick="confirmation(event, 'unverified')"
                >
                  <i class="fas fa-user-times fa-lg"></i>
                </button>

              </form>
            </td>
          </tr>
        @empty
          <div class="alert alert-danger p-4 text-center border-0 font-weight-bold">
            متأسفانه کاربری یافت نشد !!!
          </div>
        @endforelse

      </tbody>
    </table>

    {{ $employees->onEachSide(2)->links('vendor.pagination.default') }}

  </div>

  <x-confirm-modal title="تأیید کاربر"></x-confirm-modal>
@endsection

@push('scripts')
  <script>
    // Confirm user update
    function confirmation(e, status) {
      e.preventDefault();

      let form = e.target.parentElement.parentElement;

      $("#userUpdateForm input[name='verification']").val(status);

      if(status === 'unverified') {
        $("#confirmModal .confirm-modal-title").html("لغو تأیید کاربر"); 
      } else {
        $("#confirmModal .confirm-modal-title").html("تأیید کاربر"); 
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