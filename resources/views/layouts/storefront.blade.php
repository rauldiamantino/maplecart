<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Store - @yield('title')</title>
</head>
<body class="bg-black text-white w-screen">
    <div class="mx-auto container">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
