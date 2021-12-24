<div class="row flex-row-reverse justify-content-between position-relative">

  <ul class="list-group flex-row-reverse px-3 px-md-5">
    <li class="list-group-item bg-transparent px-0">
      <div class="dropdown dropdown-bell" data-user-id={{ $user->id }}>
        <button class="btn btn-secondary bg-transparent border-0 shadow-none" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @if($user->unreadNotifications->count() > 0)
            <span class="badge badge-danger rounded-circle notification-counter">
              {{ $user->unreadNotifications->count() }}
            </span>
          @endif
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell {{ $user->unreadNotifications->count() > 0 ? 'text-danger' : 'text-secondary' }}" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
          </svg>
        </button>
        @if($user->notifications->count() !== 0)
          <div class="dropdown-menu shadow border-0" aria-labelledby="dropdownMenuButton">
            @if($user->isAdmin)
              @foreach ($user->notifications as $notification)
                @if($notification->data['type'] === 'userRegistered')
                  <a class="dropdown-item lead text-right {{ $notification->unread() ? 'bg-secondary text-white' : '' }}" href="#">
                    <small>
                        کاربر جدید با نام
                      <span class="font-weight-bold">{{ $notification->data['name'] }}</span>
                      با آدرس ایمیل
                      <span class="font-weight-bold">{{ $notification->data['email'] }}</span>
                      در سامانه نام نویسی کرده است. 
                      لطفاً هویت این کاربر را بررسی نمایید.
                    </small>
                  </a>
                  <div class="dropdown-divider my-1"></div>
                @endif
              @endforeach
            @else
              @foreach ($user->notifications as $notification)
                @if($notification->data['type'] === 'vacationConfirmation')
                  <a class="dropdown-item lead text-right {{ $notification->unread() ? 'bg-secondary text-white' : '' }}" href="#">
                    <small>
                        درخواست مرخصی شما با عنوان
                      <span class="font-weight-bold">{{ $notification->data['title'] }}</span>
                      به وضعیت
                      <span class="font-weight-bold">{{ translate_status($notification->data['status'])['status'] }}</span>
                      تغییر یافته است.
                    </small>
                  </a>
                  <div class="dropdown-divider my-1"></div>
                @elseif($notification->data['type'] === 'userConfirmation')
                  <a class="dropdown-item lead text-right {{ $notification->unread() ? 'bg-secondary text-white' : '' }}" href="#">
                    @if($notification->data['isVerified'] === 'verified')
                      <small>
                        هویت شما توسط مدیر سایت 
                        <strong>تأیید</strong>
                        شده است. 
                        شما می‌توانید درخواست مرخصی خود را ثبت و نتیجه را پیگیری نمایید.
                      </small>
                    @else
                      <small>
                        هویت شما توسط مدیر سایت
                        <strong>تأیید نشده است</strong>
                        . 
                        لطفاً جهت پیگیری با واحد مربوطه تماس حاصل فرمایید.
                      </small>
                    @endif
                  </a>
                  <div class="dropdown-divider my-1"></div>
                @endif
              @endforeach
            @endif
          </div>
        @endif
      </div>
    </li>
    @if(request()->is('*vacations'))
    <li class="list-group-item bg-transparent search px-0">
      <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="جستجوی عنوان مرخصی ...">
        <button class="btn border-0 shadow-none" type="submit">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search text-secondary" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>
        </button>
      </form>
    </li>
    @endif
  </ul>

  {{-- Sidebar show btn -- mobile mode --}}
  <ul class="list-group justify-content-center px-3 d-md-none ml-auto sidebar-show">
    <li class="list-group-item bg-transparent">
      <button class="bg-transparent border-0">
        <i class="fas fa-bars fa-lg"></i>
      </button>
    </li>
  </ul>

  {{-- filters --}}
  <div class="filters-wrapper text-center">
    <ul class="list-group flex-row">
      @yield('filters')
    </ul>
    <button class="bg-transparent border-0 d-flex slider-btn">
      <i class="fas fa-angle-down fa-lg text-secondary"></i>
    </button>
  </div>

</div>

<script>
  // Filters slider btn
  let sliderBtn = document.querySelector('.filters-wrapper .slider-btn');
  let filtersWrapper = document.querySelector('.filters-wrapper');
  let sliderBtnIcom = document.querySelector('.filters-wrapper .slider-btn .fa-angle-down');

  sliderBtn.addEventListener('click', function() {
    if(filtersWrapper.classList.contains('show')) {
      filtersWrapper.classList.remove('show');
      sliderBtnIcom.classList.remove('up');
    } else {
      filtersWrapper.classList.add('show');
      sliderBtnIcom.classList.add('up');
    }
  });
</script>