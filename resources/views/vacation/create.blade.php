@extends('layouts.base')

@push('stylesheets')
  <link type="text/css" rel="stylesheet" href="{{ asset('css/jalalidatepicker.min.css') }}" />
@endpush

@section('content')
  <h4>
    @if(isset($vacation))
      ویرایش درخواست
    @else
      درخواست جدید
    @endif
  </h4>
  @if(session()->has('successMessage'))
    <div class="alert alert-success" role="alert">
      {{ session()->get('successMessage') }}
    </div>
  @endif

  <form action="{{ isset($vacation) ? route('vacations.update', ['vacation' => $vacation->id]) : route('vacations.store') }}" class="w-50 mx-auto mt-5" method="POST" autocomplete="off">
    @csrf
    @if(isset($vacation))
      @method('PATCH')
    @endif
    <div class="card request-form">
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="form-group">
              <label for="title" class="font-weight-bold">عنوان درخواست:</label>
              <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="عنوان درخواست" value="{{ isset($vacation) ? $vacation->title : '' }}">
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group mt-4">
              <label for="request_message" class="font-weight-bold">متن درخواست:</label>
              <textarea name="request_message" id="request_message" class="form-control @error('request_message') is-invalid @enderror" cols="30" rows="5" placeholder="متن درخواست">{{ isset($vacation) ? $vacation->request_message : '' }}</textarea>
              @error('request_message')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="d-flex align-items-center">
              <div class="form-group mt-3 ml-5">
                <label for="from_date" class="font-weight-bold">از تاریخ:</label>
                <input type="text" name="from_date" id="from_date" data-jdp class="form-control @error('from_date') is-invalid @enderror" placeholder="1400-05-05" value="{{ isset($vacation) ? $vacation->from_date : '' }}">
                @error('from_date')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="form-group mt-3">
                <label for="to_date" class="font-weight-bold">تا تاریخ:</label>
                <input type="text" name="to_date" id="to_date" data-jdp class="form-control @error('to_date') is-invalid @enderror" placeholder="1400-05-06" value="{{ isset($vacation) ? $vacation->to_date : '' }}">
                @error('to_date')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group mt-5 text-center">
              <input type="submit" name="submit" class="btn btn-primary btn-block font-weight-bold" value="{{ isset($vacation) ? 'ویرایش درخواست' : 'ثبت درخواست' }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  <script type="text/javascript" src="{{ asset('js/jalalidatepicker.min.js') }}"></script>
  <script>
    $(document).on('click', '#from_date', function() {
      let options = null;
      jalaliDatepicker.startWatch(options);
    });

    $(document).on('click', '#to_date', function() {
      let options = null;
      jalaliDatepicker.startWatch(options);
    });
  </script>
@endpush