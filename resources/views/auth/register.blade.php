<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="form w-100">
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

        <!--Name--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <x-text-input
                id="name"
                class="form-control bg-transparent"
                type="text"
                name="name"
                :value="old('name')"
                placeholder="Name"
                required autofocus autocomplete="name" />
            <!--end::Email-->
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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

        <!--Password--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <x-text-input
                id="password"
                class="form-control bg-transparent"
                type="password"
                name="password"
                :value="old('password')"
                placeholder="Password"
                required autofocus autocomplete="password" />
            <!--end::Email-->
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!--Confirmation Password--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <x-text-input
                id="password_confirmation"
                class="form-control bg-transparent"
                type="password"
                name="password_confirmation"
                :value="old('password_confirmation')"
                placeholder="Confirm Password"
                required autofocus autocomplete="password_confirmation" />
            <!--end::Email-->
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <x-primary-button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        <!--end::Submit button-->

        <div class="text-gray-500 text-center fw-semibold fs-6">
            Already have an Account?

            <a href="{{ route('login') }}" class="link-primary fw-semibold">
                Login
            </a>
        </div>

    </form>
</x-guest-layout>
