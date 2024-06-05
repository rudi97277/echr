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

<body x-data="sideScript" class="bg-gray-200 font-popins flex relative sm:static"
    onload="document.body.style.visibility='visible'">
    <x-admin.aside />

    <div :class="{ 'sm:ms-[-200px]': !isOpen }">
        <x-admin.header />
        @yield('content')
    </div>
    <x-popup />

    @yield('script-header')
</body>
@stack('script')
<script>
    function sideScript() {
        return {
            isOpen: true,
            closeOrOpen: function() {
                this.isOpen = !this.isOpen

            }
        }
    }
</script>

</html>
