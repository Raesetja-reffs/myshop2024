<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Report Builder File') }}
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
            <a href="{{ route('report-builder-files.index') }}" class="text-muted text-hover-primary">
                Report Builder Files Listing
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Edit Report Builder File </li>
    </x-slot>

    <div class="card mb-2 mt-2">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('report-builder-files.update', $reportBuilderFile->id) }}" class="addnovalidate" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Company Name-->
                                <div class="mb-3">
                                    <x-input-label for="company_id" :value="__('Company Name')" class="required" />
                                    <x-select-input id='company_id'
                                        name='company_id'
                                        :value="old('company_id', $reportBuilderFile->company_id)"
                                        :options="$companies"
                                        :messages='$errors->get("company_id")'
                                        placeholder="Please select company"
                                        required autofocus
                                    />
                                    <input type="hidden" id="company_name" name="company_name" value="{{ old('company_name', $reportBuilderFile->company_name) }}" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="report_type" :value="__('Report Type')" class="required" />
                                    <x-select-input id='report_type'
                                        name='report_type'
                                        :value="old('report_type', $reportBuilderFile->report_type)"
                                        :options="config('custom.dims_report')"
                                        :messages='$errors->get("report_type")'
                                        placeholder="Please select report type"
                                        required autofocus
                                    />
                                </div>

                                <div class="general_image_preview_container">
                                    <x-input-label for="file_url" :value="__('Report File Upload')" class="required" />
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
                                    <x-primary-button class="btn-sm">{{ __('Update') }}</x-primary-button>
                                    <x-a-secondary-button class="btn-sm" href="{{ route('report-builder-files.index') }}">{{ __('Cancel') }}</x-a-secondary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
