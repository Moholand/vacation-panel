@extends('layouts.main_layout')

@push('stylesheets')
  <link type="text/css" rel="stylesheet" href="{{ asset('css/jalalidatepicker.min.css') }}" />
  <link href="{{ mix('css/create_vacation_profile.css') }}" rel="stylesheet">
@endpush

@section('content')
  <h4>
    @if(isset($vacation))
      ویرایش درخواست
    @else
      درخواست جدید
    @endif
  </h4>

  <hr class="my-0">

  @include('includes.successMessage')

  <div class="row justify-content-center request-form-wrapper">
    <div class="col-md-6">
      <div class="card request-form">
        <div class="card-body">
          <form action="{{ isset($vacation) ? route('vacations.update', $vacation) : route('vacations.store') }}" class="mx-auto" method="POST" autocomplete="off">

            @csrf
            @if(isset($vacation))
              @method('PATCH')
            @endif
            
            <div class="form-group">
              <label for="title" class="font-weight-bold">عنوان درخواست:</label>
              <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="لطفاً عنوان درخواست خود را وارد نمایید..." value="{{ isset($vacation) ? $vacation->title : '' }}">
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="form-group mt-3">
              <label for="request_message" class="font-weight-bold">متن درخواست:</label>
              <textarea name="request_message" id="request_message" class="form-control @error('request_message') is-invalid @enderror" cols="30" rows="4" placeholder="لطفاً متن درخواست خود را وارد نمایید...">{{ isset($vacation) ? $vacation->request_message : '' }}</textarea>
              @error('request_message')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="type" class="font-weight-bold">نوع درخواست:</label>
                  <div class="form-check">
                    <div class="form-check form-check-inline mr-0 ml-2">
                      <input class="form-check-input ml-1" type="radio" name="type" id="type-1"  value="deserved" {{ isset($vacation) && $vacation->type === 'deserved' ? 'checked' : '' }} checked>
                      <label class="form-check-label" for="type-1">استحقاقی</label>
                    </div>
                    <div class="form-check form-check-inline mr-0">
                      <input class="form-check-input ml-1" type="radio" name="type" id="type-2" value="emergency" {{ isset($vacation) && $vacation->type === 'emergency' ? 'checked' : '' }}> 
                      <label class="form-check-label" for="type-2">استعلاجی</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group request-mode">
                  <label for="mode" class="font-weight-bold">حالت درخواست:</label>
                  <div class="form-check">
                    <div class="form-check form-check-inline mr-0 ml-2">
                      <input class="form-check-input ml-1" type="radio" name="mode" id="mode-1"  value="daily" checked>
                      <label class="form-check-label" for="mode-1">روزانه</label>
                    </div>
                    <div class="form-check form-check-inline mr-0">
                      <input class="form-check-input ml-1" type="radio" name="mode" id="mode-2" value="hourly" {{ isset($vacation) && $vacation->mode === 'hourly' ? 'checked' : '' }}>
                      <label class="form-check-label" for="mode-2">ساعتی</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row align-items-center request-date">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="from_date" class="font-weight-bold">از تاریخ:</label>
                  <input type="text" name="from_date" id="from_date" data-jdp class="form-control mr-2 @error('from_date') is-invalid @enderror" placeholder="1400/05/05" value="{{ isset($vacation) ? $vacation->from_date : '' }}">
                  @error('from_date')
                    <span class="invalid-feedback mr-3" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="to_date" class="font-weight-bold">تا تاریخ:</label>
                  <input type="text" name="to_date" id="to_date" data-jdp class="form-control mr-2 @error('to_date') is-invalid @enderror" placeholder="1400/05/06" value="{{ isset($vacation) ? $vacation->to_date : '' }}" {{ isset($vacation) && $vacation->mode === 'hourly' ? 'disabled' : '' }}>
                  @error('to_date')
                    <span class="invalid-feedback mr-3" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row request-hour">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="from_hour" class="font-weight-bold">از ساعت:</label>
                  <select id="from_hour" name="from_hour" class="form-control w-50 mr-2 px-1 @error('from_hour') is-invalid @enderror" value="{{ isset($vacation) ? $vacation->from_hour : '' }}" {{ isset($vacation) && $vacation->mode === 'hourly' ? '' : 'disabled' }}>
                    <option value="">ساعت شروع</option>
                    @for ($hour = 9; $hour <= 17; $hour++)
                      <option value="{{ $hour }}" {{ isset($vacation) && $vacation->from_hour == $hour ? 'selected' : '' }}>{{ $hour == 9 ? '0' . $hour : $hour }}</option>
                    @endfor
                  </select>
                  @error('from_hour')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="to_hour" class="font-weight-bold">تا ساعت:</label>
                  <select id="to_hour" name="to_hour" class="form-control w-50 mr-2 px-1 @error('to_hour') is-invalid @enderror" {{ isset($vacation) && $vacation->mode === 'hourly' ? '' : 'disabled' }}>
                    <option value="">ساعت پایان</option>
                    @for ($hour = 9; $hour <= 17; $hour++)
                      <option value="{{ $hour }}" {{ isset($vacation) && $vacation->to_hour == $hour ? 'selected' : '' }}>{{ $hour == 9 ? '0' . $hour : $hour }}</option>
                    @endfor
                  </select>
                  @error('to_hour')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="form-group mt-1 text-center">
              <input type="submit" name="submit" class="btn btn-secondary btn-block font-weight-bold" value="{{ isset($vacation) ? 'ویرایش درخواست' : 'ثبت درخواست' }}">     
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
  <script type="text/javascript" src="{{ asset('js/jalalidatepicker.min.js') }}"></script>
  <script>
    $( document ).ready(function() {
      // Date picker start
      let options = {
        minDate: 'today',
      };
      jalaliDatepicker.startWatch(options);

      // Request mode settings
      $('.request-mode input').on('change', function(e) {
        let mode = $('.request-mode input[name="mode"]:checked').val();
        if(mode === 'daily') {
          $('.request-date input[name="to_date"]').prop('disabled', false);
          $('.request-hour select[name="from_hour"], .request-hour select[name="to_hour"]').attr('disabled', 'disabled');
        } else {
          $('.request-date input[name="to_date"]').prop('disabled', true);
          $('.request-hour select[name="from_hour"], .request-hour select[name="to_hour"]').removeAttr('disabled');
        }
      });
    });
  </script>
@endpush