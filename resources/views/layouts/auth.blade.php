<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreData Sdn. Bhd. HelpDesk">
    <title>{{ config('app.name', 'HelpDesk') }}</title>
    <link rel="shortcut icon" href="/images/coredata-logo-only.png">
    <link rel="stylesheet" href="/assets/css/style.css?v1.1.2">
</head>

<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
    <!-- Root  -->
    <div class="nk-app-root">
        <!-- main  -->
        <div class="nk-main">
            <div class="nk-wrap align-items-center justify-content-center has-mask">
                <div class="mask mask-3"></div><!-- .mask-->
                @yield('content')
            </div>
        </div> <!-- .nk-main -->
    </div> <!-- .nk-app-root -->
</body>
<!-- JavaScript -->
<script src="./assets/js/bundle.js"></script>
<script src="./assets/js/scripts.js"></script>

</html>