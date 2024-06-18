<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi | {{ AppHelper::fullWebName() }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            visibility: hidden
        }
    </style>
</head>

<body x-data="sideScript" class="bg-white font-popins flex relative sm:static"
    onload="document.body.style.visibility='visible'">
    <x-admin.aside />

    <div :class="{ 'sm:ms-[-200px]': !isOpen }" class="flex flex-col flex-grow min-w-0 h-screen">
        <x-admin.header />
        <main class="flex px-4 pt-4 w-full h-[90%] flex-grow bg-white flex-col">
            <x-admin.breadcrums />
            @yield('content')
        </main>
    </div>
    <x-popup />

    @yield('script-header')
</body>
@stack('script')
<script>
    function sideScript() {
        return {
            isOpen: window.innerWidth >= 640 ? true : false,
            closeOrOpen: function() {
                this.isOpen = !this.isOpen
            }
        }
    }
</script>

</html>
