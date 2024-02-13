<script src="https://kit.fontawesome.com/b829c5162c.js" crossorigin="anonymous"></script>
<script src="{{ asset('admin_app/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <!-- Kanban scripts -->
  <script src="{{ asset('admin_app/assets/js/plugins/dragula/dragula.min.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/plugins/jkanban/jkanban.js') }}"></script>
  <script src="{{ asset('admin_app/assets/js/plugins/chartjs.min.js') }}"></script>
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
  <script src="{{ asset('admin_app/assets/js/material-dashboard.min.js?v=3.0.6') }}"></script>
</body>

</html>
