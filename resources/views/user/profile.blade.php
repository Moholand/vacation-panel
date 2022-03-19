@extends('layouts.main_layout')

@push('stylesheets')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
  <link href="{{ mix('css/create_vacation_profile.css') }}" rel="stylesheet">
@endpush

@section('content')
  <h4>ویرایش پروفایل</h4>
  <hr>

  @include('includes.successMessage')

  <div class="update-profile-form mt-3">

    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="card profile-form">
          <div class="card-body">

            <div class="row justify-content-center mb-3 profile-image-section">
              <div class="col-md-4">
                <div class="image_area">
                  <form method="POST">
                    @csrf
                    <label for="uploadImage">
                      <img 
                        src="{{ $user->getAvatarPath($user->avatar) }}" 
                        id="uploaded_image" class="img-responsive rounded-circle" width="160"
                      >
                      <div class="overlay">
                        <div class="text">
                          تغییر عکس پروفایل
                        </div>
                      </div>
                      <input type="file" name="image" class="image" id="uploadImage" data-user="{{ $user->id }}">
                    </label>
                  </form>
                </div>
              </div>
            </div>
    
            <div class="row justify-content-center">
              <div class="col">
                <form action="{{ route('profile.update', ['user' => $user->id]) }}" autocomplete="off" method="POST">
                  @csrf
                  @method('PATCH')
            
                  <div class="row justify-content-center">
                    <div class="col-md-4 right-col">
                      <div class="form-group">
                        <label for="name" class="font-weight-bold">نام:</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="نام و نام خانوادگی" value="{{ $user->name }}"> 
                      </div>
                      <div class="form-group">
                        <label for="password" class="font-weight-bold">رمز عبور:</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="**************"> 
                      </div>
                    </div>
                    <div class="col-md-4 left-col">
                      <div class="form-group">
                        <label for="email" class="font-weight-bold">ایمیل:</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="آدرس ایمیل" value="{{ $user->email }}">
                      </div>

                      {{-- User Department Update --}}
                      <div class="form-group">
                        <label for="department_id" class="font-weight-bold">
                          واحد کاری:
                        </label>
                        <select 
                          name="department_id" 
                          id="department_id"
                          class="form-control"
                          value="{{ $user->position }}">
                        >
                          @foreach($departments as $department)
                            <option 
                              value="{{ $department->id }}" 
                              {{ $department->id === $user->department->id ? 'selected' : '' }}
                            >
                              {{ $department->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                      
                    </div>
                    <div class="col-md-8">
                      <div class="form-group text-left">
                        <input type="submit" name="submit" class="btn btn-secondary btn-block mt-3 text-white font-weight-bold" value="ویرایش پروفایل">
                      </div>
                    </div>
                  </div>
                    
                </form>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
    
  </div>
  <!-- Modal -->
  <div class="modal fade modal-cropper" id="modal" dir="ltr" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
              <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              <h5 class="modal-title">برش تصویر قبل از بارگذاری</h5>
            </div>
            <div class="modal-body">
                <div class="image-container">
                    <div class="row flex-nowrap">
                        <div class="col-md-8" style="width: 650px">
                            <img id="sample_image" style="display: block; max-width: 100%">
                        </div>
                        <div class="col-md-4" style="width: 300px">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">بازگشت</button>
                <button type="button" id="crop" class="btn btn-primary">برش</button>
            </div>
        </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
  
  <script>
    $(document).ready(function() {
      let $modal = $('#modal');
      let image = $('#sample_image');
      let cropper;

      let baseUrl = 'http://127.0.0.1:8000/';
      $.ajaxSetup({
          beforeSend: function(xhr, options) {
              options.url = baseUrl + options.url;
          }
      });

      $(document).on("change", "#uploadImage", function(e){
        let files = e.target.files;
        let done = function (url) {
          image.attr('src', url);
          $modal.modal('show');
        };

        if (files && files.length > 0) {
          let reader = new FileReader();
          reader.onload = function(event) {
            done(reader.result);
          };
          reader.readAsDataURL(files[0]);
        }
      });
      $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image[0], {
          aspectRatio: 1,
          viewMode: 3,
          preview: '.preview'
        });
      }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
      });

      $("#crop").click(function(){
        canvas = cropper.getCroppedCanvas({
          width: 160,
          height: 160,
        });

        canvas.toBlob(function(blob) {
          url = URL.createObjectURL(blob);
          let reader = new FileReader();
          reader.readAsDataURL(blob); 
          reader.onloadend = function() {
            let base64data = reader.result; 
            $.ajax({
              type: "POST",
              dataType: "json",
              url: "api/crop-image-upload",
              data: {
                '_token': $(".image_area input[type='hidden']").val(), 
                'image': base64data,
                'userId': $('#uploadImage').attr('data-user')
              },
              success: function(data){
                $modal.modal('hide');
                $('#uploaded_image').attr('src', data.success);
                $('.user-image img').attr('src', data.success);
              }
            });
          }
        });
      });
    });
  </script>
@endpush
