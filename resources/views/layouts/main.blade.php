<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="author" content="sinec-technology">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <meta name="description" content="Multi-purpose admin dashboard template that especially build for programmers."> --}}
    <title>{{ config('app.name', 'HelpDesk') }}</title>
    <link rel="shortcut icon" href="/images/coredata-logo-only.png">
    <link rel="stylesheet" href="/assets/css/style.css?v1.1.2">
    @yield('css')
</head>

<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
    <!-- Root -->
    <div class="nk-app-root">
        <!-- main  -->
        <div class="nk-main">
            <!-- .nki-sidebar -->
            @include('_partial.sidebar')
            <!-- sidebar @e -->
            <!-- wrap -->
            <div class="nk-wrap">
                <!-- include Header  -->
                @include('_partial.header')
                <!-- header -->
                <!-- content -->
                @yield('content')
                <!-- .nk-content -->
                <!-- include Footer -->
                @include('_partial.footer')
                <!-- .nk-footer -->
            </div> <!-- .nk-wrap -->
        </div> <!-- .nk-main -->
    </div> <!-- .nk-app-root -->
</body>
<!-- JavaScript -->
<script src="/assets/js/bundle.js"></script>
<script src="/assets/js/scripts.js"></script>
@include('_partial.notification')
@yield('js')
@stack('js-stack')
</html>