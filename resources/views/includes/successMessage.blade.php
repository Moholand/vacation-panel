@if(session()->has('successMessage'))
  <div class="alert alert-success mb-0 d-flex justify-content-between align-items-center" role="alert">
    <span class="message-content">{{ session()->get('successMessage') }}</span>
    <span class="close-message"><i class="fas fa-times"></i></span>
  </div>
@endif