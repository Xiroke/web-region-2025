<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/style.css'])
    <title>@yield('name', 'Админ панель')</title>
    @yield('head')
</head>
<body>
    @yield('content')
</body>
</html>
