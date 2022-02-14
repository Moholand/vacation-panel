<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="{{ asset('js/script.js') }}" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  @stack('scripts')

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link href="{{ mix('css/main.css') }}" rel="stylesheet">
  <link href="{{ mix('css/base_layout.css') }}" rel="stylesheet">
  <link href="{{ mix('css/sidebar.css') }}" rel="stylesheet">
  <link href="{{ mix('css/header.css') }}" rel="stylesheet">
  @stack('stylesheets')
</head>
<body>
  <main class="main">
    <div class="sidebar">
      @include('includes.sidebar')
    </div>
    <div class="content">
      <div class="content-header">
        @include('includes.contentHeader')
      </div>
      <div class="content-inner">
        @yield('content')
      </div>
    </div>
  </main>
</body>
</html>
