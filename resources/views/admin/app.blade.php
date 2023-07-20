<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    @include('admin.link')

    @if ($env === 'production')
	    <link href="{{ asset('sources/admin/app-da38fd7d.css?' . strtotime("now")) }}">
    @endif
</head>
<body class="sidebar-mini control-sidebar-slide-open layout-navbar-fixed layout-fixed">
    <div id="app"></div>

    @if ($env === 'production')
	    <script src="{{ asset('sources/admin/app-c31aa95e.js?' . strtotime("now")) }}"></script>
    @else
        @vite('resources/js/admin/app.js')
    @endif

    @include('admin.script')
</body>
</html>
