<x-app-layout>
    <x-slot name="header">
        {{ __('Report Engine Files Listing') }}
    </x-slot>
    <x-slot name="breadcrum">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Report Engine Files Listing </li>
    </x-slot>
    <x-slot name="toolbarrightside">
        <a class="btn btn-info btn-sm ms-1 me-1" href="{{ asset('reports/DevExDesigner V1.0.0.zip') }}">
            Download Report Designer Tool(.exe)
        </a>
        <div class="d-flex justify-end sample-download-div">
            <div class="w-150px">
                <x-select-input id='DimsReport'
                    name='DimsReport'
                    value=""
                    :options="config('custom.dims_report')"
                    placeholder="Select Report Type"
                    class="me-1 mb-1 mb-sm-0"
                    data-allow-clear="true"
                    required autofocus
                />
            </div>
            <a class="downloadLink" style="display: none;"></a>
            <button class="btn btn-info btn-sm ms-1 me-1 download-sample-file" url="{{ route('report-builder-files.download-sample-file', [0]) }}">
                Download Sample Report
            </button>
        </div>
    </x-slot>

    <div class="card card-flush m-3 mb-2 mt-2">
        <!--begin::Card header-->
        <form id="searchForm" action="{{ route('report-builder-files.index') }}" method="GET" class="addnovalidate">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="d-flex w-100 align-items-center flex-wrap">
                    <div class="d-flex align-items-center position-relative my-1 flex-grow-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                        <input type="text" name="search"
                            class="form-control ps-12"
                            placeholder="Search report builder file by company name"
                            value="{{ request()->query('search') }}"
                        >
                    </div>
                    <button type="submit" class="btn btn-info btn-sm me-1 mb-1 mb-sm-0">Search</button>
                    @if (auth()->guard('central_api_user')->user()->isSuperAdmin())
                        <div class="w-200px">
                            <x-select-input id='selectedCompanies'
                                name='selectedCompanies[]'
                                :value="request()->query('selectedCompanies')"
                                :options="$companies"
                                :messages='$errors->get("selectedCompanies")'
                                placeholder="Select companies"
                                class="me-1 mb-1 mb-sm-0"
                                data-allow-clear="true"
                                multiple="multiple"
                                required autofocus autocomplete='selectedCompanies' />
                        </div>
                        <button type="submit" class="btn btn-info btn-sm ms-1 me-1">Apply Filter</button>
                    @endif
                    @if (auth()->guard('central_api_user')->user()->can('create', App\Models\CentralUser::class))
                        <a href="{{ route('report-builder-files.create') }}" class="btn btn-primary btn-sm">
                            Add Report Engine File
                        </a>
                    @endif
                </div>
            </div>
        </form>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200 text-uppercase">
                            <th class="">Id</th>
                            <th class="">Company Name</th>
                            <th class="">Report Type</th>
                            <th class="">File URL</th>
                            <th class="">Creared At</th>
                            <th style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reportBuilderFiles as $reportBuilderFile)
                            <tr>
                                <td>{{ $reportBuilderFile->id }}</td>
                                <td>
                                    {{ $reportBuilderFile->company_name }}
                                </td>
                                <td>
                                    {{ config('custom.dims_report_values')[$reportBuilderFile->report_type] }}
                                </td>
                                <td>
                                    <a href="{{ $reportBuilderFile->file_url }}" title="{{ $reportBuilderFile->report_type }}" alt="{{ $reportBuilderFile->report_type }}">
                                        Download File
                                    </a>
                                </td>
                                <td>{{ $reportBuilderFile->created_at }}</td>
                                <td class="d-flex" style="width: 200px;">
                                    <a href="{{ route('report-builder-files.show', $reportBuilderFile->id) }}" class="btn btn-info btn-sm me-1">View</a>
                                    <a href="{{ route('report-builder-files.edit', $reportBuilderFile->id) }}" class="btn btn-primary btn-sm me-1">Edit</a>
                                    <form action="{{ route('report-builder-files.destroy', $reportBuilderFile->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this report builder file?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm me-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <x-no-record-found colspan="6" />
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $reportBuilderFiles->appends([
                'search' => request()->query('search'),
                'selectedCompanies' => request()->query('selectedCompanies')
            ])->links() }}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    @push('scripts')
        <script>
            $(document).ready(function(){
                $("#searchForm button[type='submit']").on("click", function(event) {
                    if (event.keyCode === 13) { // Check if Enter key is pressed (key code 13)
                        event.preventDefault();
                        $("#searchForm").submit(); // Submit the search form
                    }
                });
                $(document).on('click', '.download-sample-file', function() {
                    let parentDiv = $(this).parents(".sample-download-div:first");
                    if (parentDiv.find("#DimsReport").val() != '') {
                        let paramsArray = $(this).attr('url').split('/');
                        if (paramsArray.length > 0) {
                            paramsArray.pop();
                        }
                        paramsArray.push(parentDiv.find("#DimsReport").val());
                        var fileUrl = paramsArray.join('/');
                        var $downloadLink = parentDiv.find('.downloadLink');
                        console.log($downloadLink)

                        // Set the href and download attributes
                        $downloadLink.attr('href', fileUrl);
                        //$downloadLink.attr('download', 'filename.pdf'); // Optional: Set desired file name here

                        // Trigger the click event to download the file
                        $downloadLink.get(0).click();
                    } else {
                        alert("Please select the report type.")
                    }
                });
            });
            function clearFlashMessage() {
                document.querySelector('.general_flash_message').remove();
            }
        </script>
    @endpush
</x-app-layout>
