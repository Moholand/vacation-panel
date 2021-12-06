@component('mail::message')
  # {{ $employee->name }}

  @php
    switch($vacation->status) {
      case('confirmed'):
        $status = 'تأیید';
        $status_class = 'success';
        break;
      case('refuse'):
        $status = 'عدم تأیید';
        $status_class = 'danger';
        break;
      default:
        $status = 'ارسال شده';
        $status_class = 'info';
    }
  @endphp

  <p>
    درخواست مرخصی شما با عنوان
    <span class="vacation-title">{{ $vacation->title }}</span>
    به وضعیت
    <span class="status">{{ $status }}</span>
    تغییر پیدا کرده است.   
  </p>

  @component('mail::button', ['url' => $url, 'color' => 'success'])
    مشاهده درخواست‌ها
  @endcomponent

  با تشکر<br>
  موهولند
@endcomponent
