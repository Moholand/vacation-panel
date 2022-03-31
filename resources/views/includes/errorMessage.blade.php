@if(session()->has('errorMessage'))
  <div 
    class="alert alert-danger fade show d-flex align-items-center justify-content-between" 
    role="alert"
  >
    <span>{{ session()->get('errorMessage') }}</span>
    <button type="button" class="close float-left" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif