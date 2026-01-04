<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/css/nucleo.css') }}">
  <!-- Font Awesome Local -->
  <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">


  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/argon-dashboard.css') }}">

  <style>
    .main-content {
      margin-left: 17.125rem; /* default width sidenav Argon */
    }

    @media (max-width: 1199.98px) {
      .main-content {
        margin-left: 0;
      }
    }
  </style>
  @stack('styles')
</head>
<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>

    @include('backend.partials.sidebar')
    <main class="main-content position-relative border-radius-lg">
      @include('backend.partials.navbar')
      <div class="container-fluid py-4 px-4">
        @yield('content')
        {{-- @include('backend.partials.configuration') --}}
        @include('backend.partials.footer')
      </div>
    </main>

  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  
  <script>
    if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), {
        damping: 0.5
      });
    }
  </script>

  <!-- Core -->
  {{-- <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script> --}}
  <script src="{{ asset('assets/js/core/bootstrap.bundle.min.js') }}"></script>

  <!-- Github buttons -->
  <script async defer src="{{ asset('assets/js/buttons.js') }}"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.1.0') }}"></script>
  @stack('scripts')
</body>
</html>
