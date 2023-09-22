<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ICS 2.0') }} - @yield('title')</title>

    @notifyCss
    @include('layouts/sections/styles')
    
    <!-- Scripts -->
    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('layouts/sections/scriptsIncludes')
   
</head>

<body class="sb-nav-fixed">
    <div class="overlay"></div>
    <div class="loader">
        <img src="{{url('img/puff.svg')}}" width="120" alt="">
    </div>

    @include('layouts.nav-top')

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('layouts.nav-side')
        </div>
        <div id="layoutSidenav_content">
            <main>

                <!-- Layout Content -->
                @yield('content')
                <!--/ Layout Content -->
            </main>
            @include('layouts.footer')
        </div>
    </div>
    <!-- Include Scripts -->
    @include('layouts/sections/scripts')
    @include('notify::components.notify')
    @notifyJs
</body>

</html>