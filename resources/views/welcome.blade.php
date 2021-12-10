@extends('layouts.enter')

@section('content')
	<div class="row">
    <div class="col-md-5">
      <div class="welcome-box text-dark">
        <h4 class="welcome-title font-weight-bold mb-0">سامانه ثبت درخواست مرخصی و مأموریت</h4>
        <h6 class="welcome-desc font-weight-bold my-3">در کوتاه‌ترین زمان ممکن درخواست خود را ثبت و پاسخ را پیگیری نمایید</h6>
        <a href="{{ route('dashboard') }}" class="btn btn-dark font-weight-bold py-2 px-4 mt-3">
          ثبت درخواست
        </a>
      </div>
    </div>
  </div>
@endsection
