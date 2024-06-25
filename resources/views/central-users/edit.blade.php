<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        @if (auth()->user()->isAdmin())
                            <!-- Company Name-->
                            <div class="mb-3">
                                <x-input-label for="company_id" :value="__('Company Name')" class="required" />
                                <x-select-input id='company_id'
                                    name='company_id'
                                    :value="old('company_id', $user->company_id)"
                                    :options="$companies"
                                    :messages='$errors->get("company_id")'
                                    placeholder="Please select company"
                                    required autofocus autocomplete='company_id'
                                />
                            </div>
                        @endif

                        <div class="mb-3">
                            <x-input-label for="Name" :value="__('Name')" class="required" />
                            <x-text-input id="Name"
                                name="Name"
                                type="text"
                                class="form-control"
                                :value="old('Name', $user->Name)"
                                :messages="$errors->get('Name')"
                                required autofocus autocomplete="Name" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="UserName" :value="__('UserName')" class="required" />
                            <x-text-input id="UserName"
                                name="UserName"
                                type="text"
                                class="form-control"
                                :value="old('UserName', $user->UserName)"
                                :messages="$errors->get('UserName')"
                                required autofocus autocomplete="UserName" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="Email" :value="__('Email')" class="required" />
                            <x-text-input id="Email"
                                name="Email"
                                type="email"
                                class="form-control"
                                :value="old('Email', $user->Email)"
                                :messages="$errors->get('Email')"
                                required autocomplete="Email" />
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
