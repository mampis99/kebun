<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 3</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ URL::asset('/') }}LTE/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ URL::asset('/') }}LTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="{{ URL::asset('/') }}LTE/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="{{ URL::asset('/') }}LTE/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{ URL::asset('/') }}LTE/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="{{ URL::asset('/') }}LTE/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{ URL::asset('/') }}LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="{{ URL::asset('/') }}yajra/datatables.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition sidebar-mini">
  @php
      $idPerusahaan = Session::get('idPerusahaan');
  @endphp
  @if ( is_null($idPerusahaan) )
    <script>
      window.location="{{ route('logout') }}";
    </script>    
  @endif
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      @yield('navbar')
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"> </i>
          {{ Session::get('fullname') }}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">Log Out</a>
        </div>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
  <!-- /.navbar -->

  @if ($idPerusahaan == 1)
    @include('templates.sidebar')
  @else
    @include('templates.user-sidebar')
  @endif

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard v3</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v3</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<script src="{{ URL::asset('/') }}LTE/plugins/jquery/jquery.min.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ URL::asset('/') }}LTE/dist/js/adminlte.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/toastr/toastr.min.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/moment/moment.min.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/daterangepicker/daterangepicker.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/sparklines/sparkline.js"></script>
<script src="{{ URL::asset('/') }}LTE/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ URL::asset('/') }}LTE/dist/js/demo.js"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ URL::asset('/') }}LTE/dist/js/pages/dashboard3.js"></script> --}}
<script src="{{ URL::asset('/') }}yajra/datatables.min.js"></script>

<script type="text/javascript">
  $.ajaxSetup({
    headers:{
      'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
  });

  function notif(code, msg) {
    if (code == 200) {
      toastr.success(msg)
    }else if (code == 201) {
      toastr.info(msg)
    }else if (code == 300) {
      toastr.warning(msg)
    }else if (code == 400) {
      toastr.error(msg)
    }
  }

</script>
@stack('js')

</body>
</html>
