<x-guest-layout>
    <!-- Session Status -->
    <x-admin.auth-session-status class="mb-4" :status="session('status')" />
    
    <!-- title-->
    <h4 class="mt-0">{{ __('Sign In') }}</h4>
    <p class="text-muted mb-4">
        {{ __('Enter your username / email address and password to access account.') }}
    </p>

    <!-- form -->
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="username" class="form-label">Username/Email address</label>
            <x-admin.text-input id="username" class="form-control" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-admin.input-error :messages="$errors->get('username')" />
        </div>
        <div class="mb-3">
            @if (Route::has('admin.password.request'))
                <a class="text-muted float-end" href="{{ route('admin.password.request') }}">
                    <small>{{ __('Forgot your password?') }}</small>
                </a>
            @endif
            <label for="password" class="form-label">Password</label>
            <x-admin.text-input id="password" class="form-control"
                type="password"
                name="password"
                required autocomplete="current-password" 
            />

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

    </form>
    <!-- end form-->

</x-guest-layout>
