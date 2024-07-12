<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{ Vite::useBuildDirectory('/backend') }}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ SettingsHelper::get('website_name') }}</title>

    <!-- Fonts -->
    <link rel="shortcut icon" href="{{ SettingsHelper::getFavicon() }}">
    <!-- Scripts -->
    {{ Vite::useBuildDirectory('backend') }}
    @vite('resources/backend/scss/app.scss')
    @yield('styles')
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        @include('layouts.partials.menu')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    {{ $slot }}

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            @include('layouts.partials.footer')

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    <!-- App js -->
    @vite('resources/backend/js/app.js')
    @yield('scripts')
</body>


</html>
