<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reset Password') }}
        </h2>
    </x-slot>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store.reset.password', $user->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-2">
                              <label for="exampleLabel" class="form-label">Name:</label>
                            </div>
                            <div class="col-md-10">
                                {{ $user->Name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                              <label for="exampleLabel" class="form-label">UserName:</label>
                            </div>
                            <div class="col-md-10">
                                {{ $user->UserName }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                              <label for="exampleLabel" class="form-label">Email:</label>
                            </div>
                            <div class="col-md-10">
                                {{ $user->Email }}
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
                                required autocomplete="new-password-confirmation" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <x-a-secondary-button href="{{ route('users.index') }}">{{ __('Cancel') }}</x-a-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
