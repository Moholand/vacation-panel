<?php

if(!function_exists('translate_status')) {
  function translate_status($status) {
    switch($status) {
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

    return ['status' => $status, 'status_class' => $status_class];
  }
}

if(!function_exists('translate_type')) {
  function translate_type($type) {
    switch($type) {
      case('deserved'):
        $type = 'استحقاقی';
        break;
      case('emergency'):
        $type = 'استعلاجی';
        break;
      default:
        $type = 'نا‌مشخص';
    }

    return $type;
  }
}

if(!function_exists('translate_mode')) {
  function translate_mode($mode) {
    switch($mode) {
      case('daily'):
        $mode = 'روزانه';
        break;
      case('hourly'):
        $mode = 'ساعتی';
        break;
      default:
        $mode = 'نا‌مشخص';
    }

    return $mode;
  }
}