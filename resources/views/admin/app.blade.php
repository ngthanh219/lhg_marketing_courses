<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
    <div id="app"></div>

    @if ($env === 'production')
	    <script src="{{ asset('js/admin/app-8837467c.js') }}" defer></script>
    @else
        @vite('resources/js/admin/app.js')
    @endif
</body>
</html>
