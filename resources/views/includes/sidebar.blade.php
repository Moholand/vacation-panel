<div class="sidebar-inner">
  <div class="sidebar-hide d-md-none text-left">
    <button class="bg-transparent border-0 text-secondary">
      <i class="fas fa-arrow-alt-circle-right fa-2x"></i>
    </button>
  </div>
  <div class="user-info">
    <div class="user-image">
      <img width="110" 
        src="{{ $user->getAvatarPath($user->avatar) }}"
      >
    </div>
    <div class="user-name">
      <h3>{{ $user->name }}</h3>
      <h6 class="mt-3 text-secondary">
        {{ $user->department->name ?? 'واحد کاری نامشخص' }}
        {{ $user->id === $user->department->administrator->id ? ' - مدیرگروه' : '' }}
      </h6>
    </div>
  </div>
  <hr>
  <div class="sidebar-menu">
    {{-- Admin Sidebar --}}
    @if($user->isAdmin)
      <ul class="list-group">
        <li class="list-group-item mb-2 pr-0 {{ Route::is('admin.vacations.index') ? 'active' : ''}}">
          <a href="{{ route('admin.vacations.index') }}" class="d-flex align-items-center text-decoration-none">
            <i class="fas fa-file-alt w-25 text-secondary"></i>
            <span>همه‌ی درخواست‌ها</span>
          </a>
        </li>
        <li class="list-group-item pr-0 mb-2 {{ Route::is('admin.profile.show') ? 'active' : ''}}">
          <a href="{{ route('admin.profile.show') }}" class="d-flex align-items-center text-decoration-none">
            <i class="fas fa-id-badge w-25 text-secondary"></i>
            <span>ویرایش پروفایل</span>
          </a>
        </li>
        <li class="list-group-item mb-2 pr-0 {{ Route::is('admin.users.index') ? 'active' : ''}}">
          <a href="{{ route('admin.users.index') }}" class="d-flex align-items-center text-decoration-none">
            <i class="fas fa-users w-25 text-secondary"></i>
            <span>کاربر‌ها</span>
          </a>
        </li>
        <li class="list-group-item pr-0 {{ Route::is('admin.departments.*') ? 'active' : ''}}">
          <a href="{{ route('admin.departments.index') }}" class="d-flex align-items-center text-decoration-none">
            <i class="far fa-building w-25 text-secondary"></i>
            <span>واحد‌های کاری</span>
          </a>
        </li>
      </ul>
    @else
      {{-- User Sidebar --}}
      <ul class="list-group">
        <li 
          class="list-group-item pr-0 mb-2 
          {{ 
            Route::is('vacations.index') || 
            Route::is('vacations.edit') || 
            Route::is('vacations.trashed') ? 'active' : '' 
          }}"
        >
          <a href="{{ route('vacations.index') }}" class="d-flex align-items-center text-decoration-none">
            <i class="far fa-file-alt w-25 text-secondary"></i>
            <span>داشبورد</span>
          </a>
        </li>
        <li class="list-group-item pr-0 mb-2 {{ Route::is('vacations.create') ? 'active' : ''}}">
          <a href="{{ route('vacations.create') }}" class="d-flex align-items-center text-decoration-none">
            <i class="fas fa-plus-circle w-25 text-secondary"></i>
            <span>درخواست جدید</span>
          </a>
        </li>
        <li class="list-group-item pr-0 mb-2 {{ Route::is('profile.show') ? 'active' : ''}}">
          <a href="{{ route('profile.show') }}" class="d-flex align-items-center text-decoration-none">
            <i class="fas fa-user-edit w-25 text-secondary"></i>
            <span>ویرایش پروفایل</span>
          </a>
        </li>
        {{-- Check if current user is administrator of this department or not --}}
        @if($user->id === $user->department->administrator->id)
        <li class="list-group-item pr-0 mb-2 {{ Route::is('teammate-vacations.index') ? 'active' : ''}}">
          <a 
            href="{{ route('teammate-vacations.index') }}" 
            class="d-flex align-items-center text-decoration-none"
          >
            <i class="fas fa-users w-25"></i>
            <span>درخواست‌ اعضای گروه</span>
          </a>
        </li>
        @endif
      </ul>
    @endif
  </div>
  <div class="exit-btn-wrapper">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="exit-btn d-flex align-items-center">
        <i class="fas fa-sign-out-alt text-secondary pl-4 pr-2"></i>
        <span>خروج</span>
      </button>
    </form>
  </div>
</div>