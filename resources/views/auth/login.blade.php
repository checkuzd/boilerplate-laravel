<x-guest-layout>
    <!-- Session Status -->
    <x-admin.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="username" class="form-label">Username/Email address</label>
            <x-admin.text-input id="username" class="form-control" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-admin.input-error :messages="$errors->get('username')" />
        </div>
        <div class="mb-3">
            @if (Route::has('password.request'))
                <a class="text-muted float-end" href="{{ route('password.request') }}">
                    <small>{{ __('Forgot your password?') }}</small>
                </a>
            @endif
            <label for="password" class="form-label">Password</label>
            <x-admin.text-input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-admin.input-error :messages="$errors->get('password')" />
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="checkbox-signin" name="remember">
                <label class="form-check-label" for="checkbox-signin">Remember me</label>
            </div>
        </div>
        <!-- Remember Me -->

        <div class="d-grid mb-0 text-center">
            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Log In </button>
        </div>
        <!-- social-->
        <div class="text-center mt-4">
            <p class="text-muted font-16">Sign in with</p>
            <ul class="social-list list-inline mt-3">
                <li class="list-inline-item">
                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                </li>
            </ul>
        </div>
    </form>
</x-guest-layout>
