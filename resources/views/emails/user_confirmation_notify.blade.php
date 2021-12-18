@component('mail::message')
# {{ $employee->name }}

@if($isVerified === 'verified')
<p> 
  هویت شما توسط مدیر سایت
  <strong>تأیید</strong>
  شده است. 
  شما می‌توانید درخواست‌های مرخصی خود را ثبت و نتیجه را پیگیری نمایید.
</p>

@component('mail::button', ['url' => $url, 'color' => 'success'])
  ثبت درخواست مرخصی
@endcomponent
@else
<p> 
  متأسفانه هویت شما توسط مدیر سایت تأیید نشده است.
  لطفاً جهت پیگیری با واحد مربوطه تماس حاصل فرمایید.
</p>
@endif

با تشکر<br>
موهولند
@endcomponent
