<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{ Vite::useBuildDirectory('/backend') }}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Scripts -->
        @vite('resources/backend/scss/app.scss')
    </head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center">
                    <a href="{{ route('home') }}" class="logo-dark">
                        <span><img src="{{ SettingsHelper::logo() }}" alt="dark logo" height="50"></span>
                    </a>
                </div>

                <div class="my-auto">
                                                            
                    {{ $slot }}
                    
                </div>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <!-- <div class="auth-user-testimonial">
                <h2 class="mb-3">I love the color!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> It's a elegent templete. I love it very much! . <i class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    - Boilerplate Admin User
                </p>
            </div> -->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    @vite('resources/backend/js/app.js')
</body>

</html>
