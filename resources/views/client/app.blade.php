<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/admin/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <title>Trang chủ</title>
</head>
<body>
    <div id="app"></div>

    @if ($env === 'production')
	    <script src="{{ asset('js/client/app-d734b25b.js') }}" defer></script>
    @else
        @vite('resources/js/client/app.js')
    @endif
</body>
</html>
