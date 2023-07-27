<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    @if ($env === 'production')
	    <link rel="stylesheet" href="{{ asset('sources/client/app-933b74a8.css?' . strtotime("now")) }}">
    @endif
</head>
<body>
    <div id="app"></div>

    @if ($env === 'production')
	    <script src="{{ asset('sources/client/app-b31cf5ba.js?' . strtotime("now")) }}"></script>
    @else
        @vite('resources/js/client/app.js')
    @endif
</body>
</html>
