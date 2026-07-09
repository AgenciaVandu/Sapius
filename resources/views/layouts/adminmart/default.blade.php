<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G0P10R831N"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-G0P10R831N');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('vendor/adminmart/assets/images/favicon.png') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Custom CSS -->

    {{-- <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" /> --}}

    <!-- Custom CSS -->
    <link href="{{ asset('vendor/adminmart/dist/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tutorial-animation.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
    @yield('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    @php
        $hasRestrictMobile = false;
        if (request()->route()) {
            $middlewares = method_exists(request()->route(), 'gatherMiddleware') 
                ? request()->route()->gatherMiddleware() 
                : (method_exists(request()->route(), 'middleware') ? request()->route()->middleware() : []);
            $hasRestrictMobile = in_array('restrict.mobile', $middlewares);
        }
    @endphp

    @if ($hasRestrictMobile)
    <script>
        (function() {
            var ua = navigator.userAgent.toLowerCase();
            var isMobileOrTablet = /iphone|ipad|ipod|android|webos|blackberry|iemobile|opera mini/i.test(ua);
            var isMac = /macintosh|macintel|macppc|mac68k/i.test(ua);
            var isTouch = (navigator.maxTouchPoints && navigator.maxTouchPoints > 0) || ('ontouchstart' in window);

            // Detect mobile/tablet in Desktop Mode (Android/iOS)
            // On Android Desktop mode, userAgent contains "linux" and touch is active.
            // On iOS Desktop mode, userAgent contains "macintosh" and touch is active.
            var isMobileDesktopMode = isTouch && (
                /linux/i.test(ua) || isMac
            ) && (Math.min(window.screen.width, window.screen.height) < 1024);

            if (isMobileOrTablet || (isMac && isTouch) || isMobileDesktopMode) {
                // Set the touch device cookie for backend middleware checks
                document.cookie = "is_touch_device=1; path=/; max-age=86400; SameSite=Lax";
                if (window.location.pathname !== '/no-access') {
                    window.location.href = "/no-access";
                }
            }
        })();
    </script>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body @if (config('app.env') == 'production') class="security-enabled" @endif>
    @include('components.test-server-banner')
    @if(config('app.is_test_server'))
    <style>
        .topbar {
            top: 40px !important;
        }
        .left-sidebar {
            top: 104px !important; /* Original 64px + 40px banner */
        }
        .page-wrapper {
            padding-top: 40px !important;
        }
        @media (max-width: 768px) {
            .topbar {
                top: 65px !important;
            }
            .left-sidebar {
                top: 129px !important;
            }
            .page-wrapper {
                padding-top: 65px !important;
            }
        }
    </style>
    @endif
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.adminmart.menu-top')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('layouts.adminmart.menu-left')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            @section('breadcrumb')
                @include('layouts.adminmart.breadcrumb')
            @show

            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            @include('layouts.adminmart.footer')
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('vendor/adminmart/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="{{ asset('vendor/adminmart/dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/adminmart/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}">
    </script>
    <script src="{{ asset('vendor/adminmart/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('vendor/adminmart/dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    {{-- <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

    @if (Auth::check() && Auth::user()->hasRole('alumno'))
        @include('partials.security-alert')
        <script>
            window.sapiusRoutes = {
                registerStrike: "{{ route('alumno.register-strike') }}",
                locked: "{{ route('alumno.locked') }}"
            };
        </script>
        <script src="{{ asset('js/student-security.js') }}"></script>
    @endif

    @yield('javascript')
</body>

</html>
