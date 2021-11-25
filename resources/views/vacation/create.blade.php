@extends('layouts.base')

@push('stylesheets')
  {{-- <link type="text/css" rel="stylesheet" href="{{ asset('css/jalalidatepicker.min.css') }}" /> --}}
  <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
@endpush

@section('content')
  <h4>درخواست جدید</h4>
  @if(session()->has('successMessage'))
    <div class="alert alert-success" role="alert">
      {{ session()->get('successMessage') }}
    </div>
  @endif
  <form action="{{ route('vacations.store') }}" class="w-50 mx-auto mt-5" method="POST" autocomplete="off">
    @csrf
    <div class="form-group">
      <label for="title">عنوان درخواست:</label>
      <input type="text" name="title" id="title" class="form-control" placeholder="عنوان درخواست">
    </div>
    <div class="form-group mt-5">
      <label for="request_message">متن درخواست:</label>
      <textarea name="request_message" id="request_message" class="form-control" cols="30" rows="5" placeholder="متن درخواست"></textarea>
    </div>
    <div class="form-group mt-5">
      <label for="date">تاریخ:</label>
      <input type="text" name="date" id="date" data-jdp class="form-control" placeholder="1400-05-05">
    </div>
    <div class="form-group mt-5 text-center">
      <input type="submit" name="submit" class="btn btn-success" value="ثبت درخواست">
    </div>
  </form>
@endsection

@push('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
  <script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
  {{-- <script type="text/javascript" src="{{ asset('js/jalalidatepicker.min.js') }}"></script> --}}
  <script>
    // $(document).on('click', '#date', function() {
    //   let options = null;
    //   jalaliDatepicker.startWatch(options);
    // });

    //  important data picker jquery have conflect with laravel jquery so
    // the answer is two line below : 
    jQuery.noConflict();
    jQuery(document).ready(function($){
      $("#date").pDatepicker({
        initialValue: false,
        format: 'YYYY/MM/DD',
        checkDate: function(unix){
          return new persianDate(unix).day() != 7;
        }
      });
    });
  </script>
@endpush