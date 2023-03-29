<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@include('dashboard.layouts.particials.head')
<body class="g-sidenav-show rtl bg-gray-200">

@include('dashboard.layouts.particials.left-sidebar')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-x-hidden">


    @include('dashboard.layouts.particials.main-navbar')
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
