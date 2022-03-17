@extends('layouts.main_layout')

@push('stylesheets')
  <link href="{{ mix('css/departments.css') }}" rel="stylesheet">
@endpush

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
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-5">
          <form 
            action="{{ isset($department) 
              ? route('admin.departments.update', $department) 
              : route('admin.departments.store') }}" 
            method="POST"
          >
            @csrf
    
            @if(isset($department))
              @method('PATCH')
            @endif
    
            <div class="form-group row align-items-center">
              <div class="col-md-3">
                <label for="name" class="mb-0">نام واحد:</label>
              </div>
              <div class="col-md-9">
                <input 
                  type="text" 
                  name="name" 
                  placeholder="لطفاً نام واحد را وارد نمایید" 
                  class="form-control @error('name') is-invalid @enderror"
                  value="{{ isset($department) ? $department->name : old('name') }}"
                >
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="col-md-3">
                <label for="head_id" class="mb-0">مدیر واحد:</label>
              </div>
              <div class="col-md-9">
                <select 
                  name="head_id" 
                  class="form-control select-picker @error('head_id') is-invalid @enderror"
                  data-live-search="true"
                >
                  <option selected="true" disabled="disabled">انتخاب مدیر واحد</option>
                  @foreach ($users as $user)
                    <option 
                      value="{{ $user->id }}"
                      {{ old('head_id') == $user->id ? 'selected' : '' }}
                      {{ isset($department) && $department->head_id === $user->id ? 'selected' : '' }}
                    >
                      {{ $user->name }}
                    </option>
                  @endforeach
                </select>
                @error('head_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-secondary">
                {{ isset($department) ? 'ویرایش واحد' : 'ایجاد واحد' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.select-picker').select2();
    });
  </script>
@endpush
