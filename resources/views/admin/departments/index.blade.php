@extends('layouts.base')

@section('content')
  <h4>واحد‌های کاری</h4>
  <hr class="mb-0">

  @include('includes.successMessage')

  <div class="departments-list">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">نام واحد</th>
          <th scope="col">مدیر واحد</th>
          <th scope="col">تعداد پرسنل</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($departments as $key => $department)
          <tr>
            <th scope="row">{{ ++$key }}</th>
            <td>{{ $department->name }}</td>
            <td>{{ $department->head }}</td>
            <td>{{ $department->count }}</td>
          </tr>
        @empty
          <div class="alert alert-danger p-4 text-center border-0 font-weight-bold">
            متأسفانه واحدی یافت نشد !!!
          </div>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection