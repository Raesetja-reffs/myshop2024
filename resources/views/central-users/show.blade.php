<x-app-layout>
    <x-slot name="header">
        {{ __('Central User Details') }}
    </x-slot>
    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Dashboard </li>
        <!--end::Item-->
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
                                <a href="{{ route('central-users.edit', $centralUser->id) }}" class="btn btn-primary btn-sm">
                                    Edit Central User
                                </a>
                                <a href="{{ route('central-users.index') }}" class="btn btn-primary btn-sm">
                                    Central Users Listing
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
                                            <td><strong>Id</strong></td>
                                            <td>{{ $centralUser->id }}</td>
                                        </tr>
                                        @if (auth()->guard('central_api_user')->user()->isAdmin())
                                            <tr>
                                                <td><strong>Company Id</strong></td>
                                                <td>
                                                    {{ $centralUser->company_id }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Id Admin</strong></td>
                                            <td>{{ $centralUser->is_admin }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>UserName</strong></td>
                                            <td>{{ $centralUser->username }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ERP User Id</strong></td>
                                            <td>{{ $centralUser->erp_user_id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ERP UserName</strong></td>
                                            <td>{{ $centralUser->erp_apiusername }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ERP API Password</strong></td>
                                            <td>{{ $centralUser->erp_apipassword }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ERP API Auth Token</strong></td>
                                            <td>{{ $centralUser->erp_apiauthtoken }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Location Id</strong></td>
                                            <td>{{ $centralUser->location_id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At</strong></td>
                                            <td>{{ $centralUser->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated At</strong></td>
                                            <td>{{ $centralUser->updated_at }}</td>
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
