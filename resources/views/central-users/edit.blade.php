<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Central User') }}
    </x-slot>
    <x-slot name="breadcrum">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
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
        <li class="breadcrumb-item text-dark">Edit Central User </li>
    </x-slot>

    <div class="card mb-2 mt-2">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('central-users.update', $centralUser->id) }}" class="addnovalidate">
                                @csrf
                                @method('PUT')

                                @if (auth()->guard('central_api_user')->user()->isSuperAdmin())
                                    <!-- Company Name-->
                                    <div class="mb-3">
                                        <x-input-label for="company_id" :value="__('Company Name')" class="required" />
                                        <x-select-input id='company_id'
                                            name='company_id'
                                            :value="old('company_id', $centralUser->company_id)"
                                            :options="$companies"
                                            :messages='$errors->get("company_id")'
                                            placeholder="Please select company"
                                            required autofocus autocomplete='company_id'
                                        />
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <x-input-label for="username" :value="__('UserName')" class="required" />
                                    <x-text-input id="username"
                                        name="username"
                                        type="text"
                                        class="form-control"
                                        :value="old('username', $centralUser->username)"
                                        :messages="$errors->get('username')"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="erp_apiurl" :value="__('ERP API URL')" class="required" />
                                    <x-text-input id="erp_apiurl"
                                        name="erp_apiurl"
                                        type="text"
                                        class="form-control"
                                        :value="old('erp_apiurl', $centralUser->erp_apiurl)"
                                        :messages="$errors->get('erp_apiurl')"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="erp_apiusername" :value="__('ERP API UserName')" class="required" />
                                    <x-text-input id="erp_apiusername"
                                        name="erp_apiusername"
                                        type="text"
                                        class="form-control"
                                        :value="old('erp_apiusername', $centralUser->erp_apiusername)"
                                        :messages="$errors->get('erp_apiusername')"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="erp_apipassword" :value="__('ERP API Password')" class="required" />
                                    <x-text-input id="erp_apipassword"
                                        name="erp_apipassword"
                                        type="text"
                                        class="form-control"
                                        :value="old('erp_apipassword', $centralUser->erp_apipassword)"
                                        :messages="$errors->get('erp_apipassword')"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="erp_apiauthtoken" :value="__('ERP API AuthToken')" class="required" />
                                    <x-text-input id="erp_apiauthtoken"
                                        name="erp_apiauthtoken"
                                        type="text"
                                        class="form-control"
                                        :value="old('erp_apiauthtoken', $centralUser->erp_apiauthtoken)"
                                        :messages="$errors->get('erp_apiauthtoken')"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="location_id" :value="__('Location Id')" class="required" />
                                    <x-text-input id="location_id"
                                        name="location_id"
                                        type="text"
                                        class="form-control"
                                        :value="old('location_id', $centralUser->location_id)"
                                        :messages="$errors->get('location_id')"
                                        required
                                    />
                                </div>

                                @if (auth()->guard('central_api_user')->user()->isSuperAdmin())
                                    <div class="mb-3">
                                        <x-input-label for="user_role" :value="__('User Role')" class="required" />
                                        <x-select-input id='user_role'
                                            name='user_role'
                                            :value="old('user_role', $centralUser->user_role)"
                                            :options="config('custom.user_roles')"
                                            :messages='$errors->get("user_role")'
                                            placeholder="Please select user role"
                                            required autofocus autocomplete='user_role'
                                        />
                                    </div>
                                @endif

                                <div class="flex items-center gap-4">
                                    <x-primary-button class="btn-sm">{{ __('Update') }}</x-primary-button>
                                    <x-a-secondary-button class="btn-sm" href="{{ route('central-users.index') }}">{{ __('Cancel') }}</x-a-secondary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
