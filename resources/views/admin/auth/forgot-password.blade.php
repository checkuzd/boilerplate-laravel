<x-guest-layout>
    @if(session('status'))
    <!-- Session Status -->
    {{-- <x-admin.auth-session-status class="mb-4" :status="session('status')" /> --}}

    <div class="my-auto">
        <!-- email send icon with text-->
        <div class="text-center m-auto">
            <i class="mdi mdi-email-check text-primary mail-check-icon"></i>
            <h4 class="text-dark-50 text-center mt-2 fw-bold">Please check your email</h4>
            <p class="text-muted mb-4">
                A email has been send to <b>{{ old('email') }}</b>.
                Please check for an email from company and click on the included link to
                reset your password.
            </p>
        </div>

        <!-- form -->    
        <div class="mb-0 d-grid text-center">
            <a class="btn btn-primary" href="{{ route('home') }}"><i class="mdi mdi-home me-1"></i> Back to Home </a>
        </div>
        
        <!-- end form-->
    </div>
    
    @else
    <!-- title-->
    <h4 class="mt-0">{{ __('Reset Password') }}</h4>
    <p class="text-muted mb-4">
        {{ __('Enter your email address and we\'ll send you an email with instructions to reset your password.') }}
    </p>

    <!-- form -->
    <form method="POST" action="{{ route('admin.password.request') }}">
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
        <p class="text-muted">Back to <a href="{{ route('admin.login') }}" class="text-muted"><b>Log In</b></a></p>
    </footer>
    @endif
</x-guest-layout>
