@include('layouts.admin_header')
@yield('styles')
<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
   @include('layouts.admin_sidebar_header')
    <hr class="horizontal light mt-0 mb-2">
    @include('layouts.admin_sidebar')
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    @include('layouts.admin_navbar')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
          @yield('content') 

    <div class="row mt-4">
     </div>     
     @include('layouts.admin_footer')
    </div>
  </main>
  @include('layouts.admin_settings')
  <!--   Core JS Files   -->
  @include('layouts.scripts')
  @yield('scripts')