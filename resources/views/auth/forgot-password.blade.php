<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="form w-100">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">
                DIMS 24
            </h1>
            <!--end::Title-->

            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                Linx System
            </div>
            <div class="text-gray-500 fw-semibold fs-6 mt-5">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>
            <!--end::Subtitle--->
        </div>
        <!--begin::Heading-->

        <!--Email--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <x-text-input
                id="email"
                class="form-control bg-transparent"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="E-Mail Address"
                required autofocus autocomplete="email" />
            <!--end::Email-->
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <x-primary-button type="submit" class="btn btn-primary">
                {{ __('Send Password Reset Link') }}
            </x-primary-button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            <a href="{{ route('login') }}"
                class="link-primary">
                Login
            </a>
        </div>
        <!--end::Sign up-->
    </form>
</x-guest-layout>
