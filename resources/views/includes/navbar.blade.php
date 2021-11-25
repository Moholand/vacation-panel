<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse pr-5" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="{{ route('login') }}">ورود به پنل</a>
      <a class="nav-item nav-link mr-3" href="{{ route('register') }}">نام‌نویسی</a>
    </div>
  </div>
  <div class="navbar-nav">
    <a class="nav-item nav-link pl-5 mr-auto" href="{{ route('dashboard') }}">ورود به سایت</a>
  </div>
</nav>