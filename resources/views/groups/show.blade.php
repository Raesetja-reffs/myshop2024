<x-app-layout>
    <x-slot name="header">
        {{ __('Group Details') }}
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
            <a href="{{ route('groups.index') }}" class="text-muted text-hover-primary">
                Groups Listing
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">Group Details </li>
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
                                <a href="{{ route('groups.edit', $group->intGroupId) }}" class="btn btn-primary btn-sm">
                                    Edit Group
                                </a>
                                <a href="{{ route('groups.index') }}" class="btn btn-primary btn-sm">
                                    Groups Listing
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
                                            <td>{{ $group->intGroupId }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Group Name</strong></td>
                                            <td>
                                                {{ $group->strGroupName }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Group Description</strong></td>
                                            <td>{{ $group->strGroupDescription }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At</strong></td>
                                            <td>{{ date('Y-m-d H:i:s', strtotime($group->dteCreated)) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated At</strong></td>
                                            <td>{{ date('Y-m-d H:i:s', strtotime($group->dteUpdated)) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Group Users</strong></td>
                                            <td>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>User Name</th>
                                                        </thead>
                                                        <tbody>
                                                            @if($groupUsers->isEmpty())
                                                                <tr>
                                                                    <td colspan="1">
                                                                        No Record(s) Found
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                @foreach ($groupUsers as $groupUser)
                                                                    <tr>
                                                                        <td>
                                                                            @if (isset($users[$groupUser->user_id][0]))
                                                                                <a href="{{ route('central-users.show', $users[$groupUser->user_id][0]['id']) }}">
                                                                                    {{ $users[$groupUser->user_id][0]['name'] }}
                                                                                </a>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
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
