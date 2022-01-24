@extends('layouts.base')

@section('content')
  <div class="d-flex justify-content-between">
    <h4>واحد‌های کاری</h4>
    <a class="btn btn-secondary" href="{{ route('departments.create') }}">
      واحد کاری جدید
    </a>
  </div>
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
          <th scope="col">ویرایش/حذف</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($departments as $key => $department)
          <tr>
            <th scope="row">{{ ++$key }}</th>
            <td>{{ $department->name }}</td>
            <td>{{ $department->administrator->name ?? 'نامشخص'}}</td>
            <td>{{ $department->employees->count() }}</td>
            <td class="d-flex align-items-center">
              {{-- Edit Department --}}
              <a href="{{ route('departments.edit', ['department' => $department->id]) }}">
                <i class="far fa-edit fa-lg text-info"></i>
              </a>
              {{-- Delete Department --}}
              <form 
                action="{{ route('departments.destroy', ['department' => $department->id]) }}" 
                method="POST"
              >
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-transparent border-0 mr-3">
                  <i class="far fa-trash-alt fa-lg text-danger"></i>
                </button>
              </form>
            </td>
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