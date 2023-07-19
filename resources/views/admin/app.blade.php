<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/plugins/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    
    @if ($env === 'production')
	    <link href="{{ asset('sources/admin/app-da38fd7d.css?' . strtotime("now")) }}">
    @endif
</head>
<body class="sidebar-mini control-sidebar-slide-open layout-navbar-fixed layout-fixed">
    <div id="app"></div>

    @if ($env === 'production')
	    <script src="{{ asset('sources/admin/app-489d05b3.js?' . strtotime("now")) }}"></script>
    @else
        @vite('resources/js/admin/app.js')
    @endif

    <script src="{{ asset('assets/admin/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/admin/AdminLTE/dist/js/adminlte.js') }}"></script>
</body>
</html>
