<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            visibility: hidden
        }
    </style>
</head>

<body class="bg-gray-200 mb-[70px] font-popins max-w-[400px] mx-auto" onload="document.body.style.visibility='visible'">
    @yield('content')
    @if (url()->current() !== route('login') && url()->current() !== route('register'))
        @include('layouts.worker-bottom-navigation')
    @endif
    @include('layouts.popup')

    @yield('script-header')
</body>
@stack('script')

</html>
