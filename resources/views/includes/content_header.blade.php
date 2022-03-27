<div class="row flex-row-reverse justify-content-between position-relative">

  <ul class="list-group flex-row-reverse px-3 px-md-5">
    {{-- Notifications --}}
    <li class="list-group-item bg-transparent px-0">
      <div class="dropdown dropdown-bell" data-user-id={{ $user->id }}>
        <button 
          class="btn btn-secondary bg-transparent border-0 shadow-none pt-2" 
          type="button" 
          id="dropdownMenuButton" 
          data-toggle="dropdown"
        >
          @if($user->unreadNotifications->count() > 0)
            <span class="badge badge-danger rounded-circle notification-counter">
              {{ $user->unreadNotifications->count() }}
            </span>
          @endif
          <i class="far fa-bell fa-lg {{ $user->unreadNotifications->count() > 0 ? 'text-danger' : 'text-secondary' }}"></i>
        </button>
        @if($user->notifications->count() !== 0)
          <div class="dropdown-menu shadow border-0" aria-labelledby="dropdownMenuButton">
            @if($user->isAdmin)
              @foreach ($user->notifications as $notification)
                @if($notification->data['type'] === 'userRegistered')
                  <a 
                    class="dropdown-item lead text-right {{ $notification->unread() ? 'unread-notification' : '' }}" 
                    href="#"
                  >
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
                  <a 
                    class="dropdown-item lead text-right {{ $notification->unread() ? 'unread-notification' : '' }}" 
                    href="#"
                  >
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
                  <a 
                    class="dropdown-item lead text-right {{ $notification->unread() ? 'unread-notification' : '' }}" 
                    href="#"
                  >
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
                @elseif($notification->data['type'] === 'teammateVacationCreated')
                  <a 
                    class="dropdown-item lead text-right {{ $notification->unread() ? 'unread-notification' : '' }}" 
                    href="#"
                  >
                    <small>
                        درخواست مرخصی همکار شما با نام
                      <span class="font-weight-bold">{{ $notification->data['teammate']['name'] }}</span>
                      و آدرس ایمیل
                      <span class="font-weight-bold">{{ $notification->data['teammate']['email'] }}</span>
                      با عنوان 
                      <span class="font-weight-bold">{{ $notification->data['vacation']['title'] }}</span>
                      در سیستم ثبت شده است. لطفاً آنرا بررسی نمایید.
                    </small>
                  </a>
                  <div class="dropdown-divider my-1"></div>
                @endif
              @endforeach
            @endif
          </div>
        @endif
      </div>
    </li>

    {{-- Search --}}
    @if(
      Route::is('vacations.*') || 
      Route::is('teammate-vacations.index') || 
      Route::is('admin.vacations.index') || 
      request()->is('admin/users') 
    )
    <li class="list-group-item bg-transparent search px-0">
      <form class="form-inline" autocomplete="off">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="جستجو ...">
        <button class="btn border-0 shadow-none" type="submit">
          <i class="fas fa-search text-secondary fa-lg"></i>
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
    <ul class="list-group flex-row py-3 flex-wrap flex-md-nowrap">
      @yield('filters')
    </ul>
    <button class="bg-transparent border-0 d-flex align-items-center text-secondary slider-btn">
      <span class="ml-2">اعمال فیلتر</span>
      <i class="fas fa-angle-down"></i>
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