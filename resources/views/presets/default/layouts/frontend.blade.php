<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('includes.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/common/css/line-awesome.min.css') }}">

    <!-- Custom CSS-->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <!-- Magnific Popup CSS-->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}">
    <!-- Slick CSS-->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <!-- Odometer CSS-->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <!-- animate CSS-->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.min.css') }}">
    <!-- lightcase css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lightcase.css') }}">
    @stack('style-lib')
    @stack('style')

    <link rel="stylesheet"
        href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
</head>

<body>
    <!--==================== Preloader Start ====================-->
    {{-- <div class="preloader">
        <div class="loader"></div>
    </div> --}}
    <!--==================== Preloader End ====================-->

    <!--==================== Overlay Start ====================-->
    <div class="body-overlay"></div>

    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <a class="scroll-top"><i class="fas fa-angle-up"></i></a>
    <!-- ==================== Scroll to Top End Here ==================== -->

    @if (
        !Route::is('user.login') &&
            !Route::is('user.register') &&
            !Route::is('user.password.email') &&
            !Route::is('user.password.code.verify') &&
            !Route::is('user.password.reset') &&
            !Route::is('user.password.request'))
       
        @include($activeTemplate . 'components.header')
    @endif

    @php
        $pages = App\Models\Page::where('tempname', $activeTemplate)->get();
    @endphp

    @yield('content')


    @if (
        !Route::is('user.login') &&
            !Route::is('user.register') &&
            !Route::is('user.password.email') &&
            !Route::is('user.password.code.verify') &&
            !Route::is('user.password.reset') &&
            !Route::is('user.password.request'))

        @include($activeTemplate . 'components.footer')
      
    @endif

    @include($activeTemplate . 'components.cookie_popup')

    <script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/common/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- Magnific Popup js -->
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Odometer js -->
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
    <!-- Viewport js -->
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>
    <!-- apexcharts js -->
    <script src="{{ asset($activeTemplateTrue . 'js/apexcharts.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <!-- Lightcase js -->
    <script src="{{ asset($activeTemplateTrue . 'js/lightcase.js') }}"></script>

    @stack('script-lib')
    @stack('script')
    @include('includes.plugins')
    @include('includes.notify')
    @include('includes.language_js')

</body>

</html>
