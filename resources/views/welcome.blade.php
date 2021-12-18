@extends('layouts.enter')

@section('content')
	<div class="row welcome-row">
    <div class="col-md-5">
      <div class="text-dark welcome-box">
        <h3 class="welcome-title font-weight-bold mb-0">سامانه ثبت درخواست مرخصی و مأموریت</h3>
        <h6 class="welcome-desc font-weight-bold my-3">در کوتاه‌ترین زمان ممکن درخواست خود را ثبت و پاسخ را پیگیری نمایید</h6>
        <a href="{{ route('vacations.index') }}" class="btn btn-dark font-weight-bold py-2 px-4 mt-3">
          ثبت درخواست
        </a>
      </div>
    </div>
  </div>
@endsection
