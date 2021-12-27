@extends('layouts.base')

@section('content')
  <h4>
    {{ 
      isset($department) ? 'ویرایش واحد کاری' 
      : 'ایجاد واحد کاری جدید' 
    }}
  </h4>
  <hr class="mb-0">

  @include('includes.successMessage')

  <div class="departments-create">
    <div class="card p-5">
      <form action="{{ route('departments.store') }}" class="form-row" method="POST">
        @csrf
        <div class="col">
          <input 
            type="text" 
            name="name" 
            placeholder="نام واحد" 
            class="form-control @error('name') is-invalid @enderror"
            value="{{ isset($department) ? $department->name : '' }}"
          >
          @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="col">
          <select name="head" class="form-control @error('head') is-invalid @enderror">
            <option selected="true" disabled="disabled">انتخاب مدیر واحد</option>
            @foreach ($users as $user)
              <option 
                value="{{ $user->id }}"
                {{ isset($department) && $department->head === $user->id ? 'selected' : '' }}
              >
                {{ $user->name }}
              </option>
            @endforeach
          </select>
          @error('head')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-secondary">
          {{ 
            isset($department) ? 'ویرایش واحد' 
            : 'ایجاد واحد' 
          }}
        </button>
      </form>
    </div>
  </div>
@endsection