<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin_app/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('admin_app/assets/img/favicon.png') }}">
  <title>
    Authentication
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('admin_app/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('admin_app/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('admin_app/assets/css/material-dashboard.css?v=3.0.6') }}" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="bg-gray-200">
    <div class="">
        @yield('content')
    </div>

  <!--   Core JS Files   -->
  <script src="{{ asset('admin_app/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <!-- Kanban scripts -->
  <script src="{{ asset('admin_app/assets/js/plugins/dragula/dragula.min.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/plugins/jkanban/jkanban.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('admin_app/assets/js/material-dashboard.min.js') }}"></script>
</body>

</html>