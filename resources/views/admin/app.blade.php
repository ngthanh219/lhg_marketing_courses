<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    @include('admin.link')

    @if ($env === 'production')
	    <link rel="stylesheet" href="{{ asset('sources/admin/app.css') }}">
    @endif
</head>
<body class="sidebar-mini control-sidebar-slide-open layout-navbar-fixed layout-fixed">
    <div id="app"></div>

    @include('admin.script')
</body>
</html>
