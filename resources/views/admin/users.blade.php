@extends('layouts.base')

@section('content')
  <h4>همه‌ی کاربرها</h4>
  <hr>
  @if(session()->has('successMessage'))
    <div class="alert alert-success" role="alert">
      {{ session()->get('successMessage') }}
    </div>
  @endif

  <div class="users-list mt-4">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">نام ‌و ‌نام‌خوانوادگی</th>
          <th scope="col">آدرس ایمیل</th>
          <th scope="col">عنوان شغلی</th>
          <th scope="col">احراز هویت</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($employees as $key => $employe)
          <tr>
            <th scope="row">{{ ++$key }}</th>
            <td>{{ $employe->name }}</td>
            <td>{{ $employe->email }}</td>
            <td>{{ $employe->position }}</td>
            <td class="d-flex align-items-center">
              <form action="{{ route('users.update', ['user' => $employe->id]) }}" method="POST">
                @csrf
                @method("PATCH")
                <button type="submit" name="verified" value="verified" class="border-0 bg-transparent {{ $employe->isVerified ? 'text-success' : 'text-secondary' }}" title="تأیید">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                  </svg>
                </button>
                <button type="submit" name="verified" value="unverified" class="border-0 bg-transparent {{ $employe->isVerified ? 'text-secondary' : 'text-danger' }} mr-1" title="عدم تأیید">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-x" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    <path fill-rule="evenodd" d="M12.146 5.146a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                  </svg>
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
  </div>

@endsection