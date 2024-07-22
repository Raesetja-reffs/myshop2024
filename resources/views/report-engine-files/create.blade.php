<x-app-layout>
    <x-slot name="header">
        {{ __('Add Report Engine File') }}
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
            <a href="{{ route('report-engine-files.index') }}" class="text-muted text-hover-primary">
                Report Engine Files Listing
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Add Report Engine File </li>
    </x-slot>
    <div class="card mb-2 mt-2">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('report-engine-files.store') }}" class="addnovalidate" enctype="multipart/form-data">
                                @csrf

                                @if (auth()->guard('central_api_user')->user()->isSuperAdmin())
                                    <div class="mb-3">
                                        <x-input-label for="company_id" :value="__('Company Name')" class="required" />
                                        <x-select-input id='company_id'
                                            name='company_id'
                                            :value="old('company_id')"
                                            :options="$companies"
                                            :messages='$errors->get("company_id")'
                                            placeholder="Please select company"
                                            required autofocus autocomplete='company_id'
                                        />
                                        <input type="hidden" id="company_name" name="company_name" value="{{ old('company_name') }}" />
                                    </div>
                                @endif

                                <div class="general_image_preview_container">
                                    <div class="mb-3">
                                        <x-text-input id="file_url"
                                            name="file_url"
                                            type="file"
                                            class="form-control general_image_upload"
                                            :messages="$errors->get('file_url')"
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button class="btn-sm">{{ __('Save') }}</x-primary-button>
                                    <x-a-secondary-button class="btn-sm" href="{{ route('report-engine-files.index') }}">{{ __('Cancel') }}</x-a-secondary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
