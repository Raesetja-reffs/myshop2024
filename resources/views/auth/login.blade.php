<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!--begin::Form-->
    <form method="POST" action="{{ route('login') }}" class="form w-100">
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
            <!--end::Subtitle--->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <x-text-input
                id="UserName"
                class="form-control bg-transparent"
                type="text"
                name="UserName"
                :value="old('UserName')"
                placeholder="UserName"
                required autofocus autocomplete="UserName" />
            <!--end::Email-->
            <x-input-error :messages="$errors->get('UserName')" class="mt-2" />
        </div>

        <!--end::Input group--->
        <div class="fv-row mb-3">
            <x-text-input
                id="Password"
                class="form-control bg-transparent"
                type="password"
                name="Password"
                placeholder="Password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('Password')" class="mt-2" />
            <!--end::Password-->
        </div>
        <!--end::Input group--->

        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>

            <!--begin::Link-->
            <a href="{{ route('password.request') }}"
                class="link-primary">
                Forgot Password ?
            </a>
            <!--end::Link-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <x-primary-button type="submit" class="btn btn-primary">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            Not a Member yet?

            <a href="{{ route('register') }}"
                class="link-primary">
                Sign up
            </a>
        </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->
</x-guest-layout>
