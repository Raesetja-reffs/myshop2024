<x-app-layout>
    <x-slot name="header">
        {{ __('Groups Listing') }}
    </x-slot>
    <x-slot name="breadcrum">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Groups Listing </li>
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
                            placeholder="Search group file by name"
                            value="{{ request()->query('search') }}"
                        >
                    </div>
                    <button type="submit" class="btn btn-info btn-sm me-1 mb-1 mb-sm-0">Search</button>
                    <a href="{{ route('groups.create') }}" class="btn btn-primary btn-sm">
                        Add Group
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
                            <th class="">Group Name</th>
                            <th class="">Group Description</th>
                            <th class="">No Of Users</th>
                            <th class="">Creared At</th>
                            <th style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($groups as $group)
                            <tr>
                                <td>{{ $group->intGroupId }}</td>
                                <td>
                                    {{ $group->strGroupName }}
                                </td>
                                <td>
                                    {{ $group->strGroupDescription }}
                                </td>
                                <td>
                                    @if (isset($groupWiseNoOfUsers[$group->intGroupId]) && isset($groupWiseNoOfUsers[$group->intGroupId][0]))
                                        <a href="{{ route('groups.show', $group->intGroupId) }}">
                                            {{ $groupWiseNoOfUsers[$group->intGroupId][0]->total }}
                                        </a>
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>{{ date('Y-m-d H:i:s', strtotime($group->dteCreated)) }}</td>
                                <td class="d-flex" style="width: 200px;">
                                    <a href="{{ route('groups.show', $group->intGroupId) }}" class="btn btn-info btn-sm me-1">View</a>
                                    <a href="{{ route('groups.edit', $group->intGroupId) }}" class="btn btn-primary btn-sm me-1">Edit</a>
                                    <form action="{{ route('groups.destroy', $group->intGroupId) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
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
            {{ $groups->appends([
                'search' => request()->query('search'),
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
