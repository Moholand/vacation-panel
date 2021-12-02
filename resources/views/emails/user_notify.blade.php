@component('mail::message')
# Introduction

The body of your message.
bia biaaaaaa....

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
