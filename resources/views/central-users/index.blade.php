<x-app-layout>
    <x-slot name="header">
        {{ __('Central Users Listing') }}
    </x-slot>
    <x-slot name="breadcrum">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Central Users Listing </li>
    </x-slot>

    <div class="card card-flush m-3 mb-2 mt-2">
        <!--begin::Card header-->
        <form id="searchForm" action="{{ route('central-users.index') }}" method="GET" class="addnovalidate">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="d-flex w-100 align-items-center flex-wrap">
                    <div class="d-flex align-items-center position-relative my-1 flex-grow-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                        <input type="text" name="search"
                            class="form-control ps-12"
                            placeholder="Search central users by username, erp user id, erp username"
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
                    <a href="{{ route('central-users.create') }}" class="btn btn-primary btn-sm">
                        Add Central User
                    </a>
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
                            @if (auth()->guard('central_api_user')->user()->isSuperAdmin())
                                <th class="">User Role</th>
                                <th class="">Company Name</th>
                            @endif
                            <th class="">UserName</th>
                            <th class="">ERP User Id</th>
                            <th class="">ERP API URL</th>
                            <th class="">Creared At</th>
                            <th style="width: {{ auth()->guard('central_api_user')->user()->isSuperAdmin() ? '360': '150' }}px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($centralUsers as $centralUser)
                            <tr>
                                <td>{{ $centralUser->id }}</td>
                                @if (auth()->guard('central_api_user')->user()->isSuperAdmin())
                                    <td>
                                        @isset(config('custom.user_roles_values')[$centralUser->user_role])
                                            {{ config('custom.user_roles_values')[$centralUser->user_role] }}
                                        @else
                                            -
                                        @endisset
                                    </td>
                                    <td>
                                        {{ $centralUser->company_name }}
                                    </td>
                                @endif
                                <td>{{ $centralUser->username }}</td>
                                <td>{{ $centralUser->erp_user_id }}</td>
                                <td>{{ $centralUser->erp_apiurl }}</td>
                                <td>{{ $centralUser->created_at }}</td>
                                <td class="d-flex" style="width: {{ auth()->guard('central_api_user')->user()->isSuperAdmin() ? '360': '150' }}px;">
                                    <a href="{{ route('central-users.show', $centralUser->id) }}" class="btn btn-info btn-sm me-1">View</a>
                                    <a href="{{ route('central-users.edit', $centralUser->id) }}" class="btn btn-primary btn-sm me-1">Edit</a>
                                    @if (auth()->guard('central_api_user')->user()->can('delete', $centralUser))
                                        <form action="{{ route('central-users.destroy', $centralUser->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this central user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm me-1">Delete</button>
                                        </form>
                                    @endcan
                                    @if (auth()->guard('central_api_user')->user()->can('resetPassword', $centralUser))
                                        <a href="{{ route('central-users.reset.password', $centralUser->id) }}" class="btn btn-primary btn-sm">Reset Password</a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <x-no-record-found colspan="7" />
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $centralUsers->appends([
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
            });
            function clearFlashMessage() {
                document.querySelector('.general_flash_message').remove();
            }
        </script>
    @endpush
</x-app-layout>
