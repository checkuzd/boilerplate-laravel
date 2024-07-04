<x-guest-layout>
    <!-- Session Status -->
    <x-admin.auth-session-status class="mb-4" :status="session('status')" />
    
    <!-- title-->
    <h4 class="mt-0">{{ __('Reset Password') }}</h4>
    <p class="text-muted mb-4">
        {{ __('Enter your email address and we\'ll send you an email with instructions to reset your password.') }}
    </p>

    <!-- form -->
    <form method="POST" action="{{ route('password.request') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email address') }}</label>
            <x-admin.text-input id="email" class="form-control" type="text" name="email" :value="old('email')" required autofocus autocomplete="email" />
            <x-admin.input-error :messages="$errors->get('email')" />
        </div>
        
        <div class="d-grid mb-0 text-center">
            <button class="btn btn-primary" type="submit">
                <i class="mdi mdi-lock-reset"></i>{{ __('Reset Password') }}
            </button>
        </div>

    </form>
    <!-- end form-->

    <footer class="footer footer-alt">
        <p class="text-muted">Back to <a href="{{ route('login') }}" class="text-muted ms-1"><b>Log In</b></a></p>
    </footer>

</x-guest-layout>
