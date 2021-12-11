@component('mail::message')
  # {{ $employee->name }}

  <p>
    درخواست مرخصی شما با عنوان
    <span class="vacation-title">{{ $vacation->title }}</span>
    به وضعیت
    <span class="status">{{ translate_status($vacation->status)['status'] }}</span>
    تغییر پیدا کرده است.   
  </p>

  @component('mail::button', ['url' => $url, 'color' => 'success'])
    مشاهده درخواست‌ها
  @endcomponent

  با تشکر<br>
  موهولند
@endcomponent
