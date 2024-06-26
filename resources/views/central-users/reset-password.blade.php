<x-app-layout>
    <x-slot name="header">
        {{ __('Reset Password') }}
    </x-slot>
    <x-slot name="breadcrum">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('central-users.index') }}" class="text-muted text-hover-primary">
                Central Users Listing
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Reset Password </li>
    </x-slot>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('central-users.store.reset.password', $centralUser->id) }}" method="POST" class="addnovalidate">
                        @csrf

                        @if (auth()->guard('central_api_user')->user()->isSuperAdmin())
                            <div class="row">
                                <div class="col-md-2">
                                  <label for="exampleLabel" class="form-label">Company Id:</label>
                                </div>
                                <div class="col-md-10">
                                    {{ $centralUser->company_id }}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-2">
                              <label for="exampleLabel" class="form-label">UserName:</label>
                            </div>
                            <div class="col-md-10">
                                {{ $centralUser->username }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                              <label for="exampleLabel" class="form-label">ERP User Id:</label>
                            </div>
                            <div class="col-md-10">
                                {{ $centralUser->erp_user_id }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-input-label for="password" :value="__('New Password')" class="required" />
                            <x-text-input id="password"
                                name="password"
                                type="password"
                                class="form-control"
                                :value="old('password')"
                                :messages="$errors->get('password')"
                                required autocomplete="new-password" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="password_confirmation" :value="__('New Confirm Password')" class="required" />
                            <x-text-input id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                class="form-control"
                                :value="old('password_confirmation')"
                                :messages="$errors->get('password_confirmation')"
                                required
                            />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="btn-sm">{{ __('Update') }}</x-primary-button>
                            <x-a-secondary-button class="btn-sm" href="{{ route('central-users.index') }}">{{ __('Cancel') }}</x-a-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
