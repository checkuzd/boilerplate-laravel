<x-guest-layout>
    <!-- title-->
    <h4 class="mt-0">{{ __('Reset Password') }}</h4>
    <p class="text-muted mb-4">
        {{ __('Reset your new password.') }}
    </p>

    <!-- form -->
    <form method="POST" action="{{ route('admin.password.store') }}">
        @csrf
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ $request->email }}">
        
        <!-- password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <x-admin.text-input id="password" class="form-control" type="password" name="password" :value="old('password')" required autofocus autocomplete="password" />
            <x-admin.input-error :messages="$errors->get('password')" />
            <x-admin.input-error :messages="$errors->get('email')" />
        </div>
        <!-- password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <x-admin.text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation"  required />
            <x-admin.input-error :messages="$errors->get('password_confirmation')" />
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
</x-guest-layout>
