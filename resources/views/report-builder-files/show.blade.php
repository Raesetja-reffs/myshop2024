<x-app-layout>
    <x-slot name="header">
        {{ __('Report Builder File Details') }}
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
        <li class="breadcrumb-item text-dark">Report Builder File Details </li>
    </x-slot>

    <div class="card mb-2 mt-2">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <a href="{{ route('report-builder-files.edit', $reportBuilderFile->id) }}" class="btn btn-primary btn-sm">
                                    Edit Report Builder File
                                </a>
                                <a href="{{ route('report-builder-files.index') }}" class="btn btn-primary btn-sm">
                                    Report Builder Files Listing
                                </a>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <td style="width: 200px;"><strong>Id</strong></td>
                                            <td>{{ $reportBuilderFile->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Company Name</strong></td>
                                            <td>
                                                {{ $reportBuilderFile->company_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Report Type</strong></td>
                                            <td>{{ $reportBuilderFile->report_type }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>File URL</strong></td>
                                            <td>
                                                <a href="{{ $reportBuilderFile->file_url }}" title="{{ $reportBuilderFile->report_type }}" alt="{{ $reportBuilderFile->report_type }}">
                                                    Download File
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At</strong></td>
                                            <td>{{ $reportBuilderFile->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated At</strong></td>
                                            <td>{{ $reportBuilderFile->updated_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
