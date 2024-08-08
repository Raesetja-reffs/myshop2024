<x-app-layout>
    <x-slot name="header">
        {{ __('Add Group') }}
    </x-slot>
    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('groups.index') }}" class="text-muted text-hover-primary">
                Groups Listing
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Add Group </li>
    </x-slot>
    <div class="card mb-2 mt-2">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('groups.store') }}" class="addnovalidate" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <x-input-label for="strGroupName" :value="__('Group Name')" class="required" />
                                    <x-text-input id="strGroupName"
                                        name="strGroupName"
                                        type="text"
                                        class="form-control"
                                        :value="old('strGroupName')"
                                        :messages="$errors->get('strGroupName')"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="strGroupDescription" :value="__('Group Description')" class="required" />
                                    <x-text-input id="strGroupDescription"
                                        name="strGroupDescription"
                                        type="text"
                                        class="form-control"
                                        :value="old('strGroupDescription')"
                                        :messages="$errors->get('strGroupDescription')"
                                        required
                                    />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button class="btn-sm">{{ __('Save') }}</x-primary-button>
                                    <x-a-secondary-button class="btn-sm" href="{{ route('groups.index') }}">{{ __('Cancel') }}</x-a-secondary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
