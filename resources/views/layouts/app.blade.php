<!DOCTYPE html>
<html lang="{{ config('app.locale', 'en') }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />

    <title>@yield('title', 'INVENTARIS')</title>

    <!-- CSRF token for forms & axios -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon (optional) -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    {{-- Google Analytics only in production --}}
    @if(app()->environment('production') && config('services.ga.ua'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga.ua') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.ga.ua') }}');
        </script>
    @endif

</head>

<body>
    @yield('content')

    <!-- General JS Scripts (jQuery first, then plugins, then template scripts) -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Optional plugins -->
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>

    <!-- Template core -->
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    {{-- Page specific JS --}}
    @stack('scripts')
</body>

</html>
