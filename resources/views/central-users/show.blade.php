<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                            Edit User
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">
                            User Listing
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
                                    <td>{{ $user->id }}</td>
                                </tr>
                                @if (auth()->user()->isAdmin())
                                    <tr>
                                        <td><strong>Company Name</strong></td>
                                        <td>
                                            @if ($user->company && $user->company->name)

                                                <a href="{{ route('companies.show', $user->company->id) }}">
                                                    {{ $user->company->name }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Name</strong></td>
                                    <td>{{ $user->Name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>UserName</strong></td>
                                    <td>{{ $user->UserName }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{ $user->Email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created At</strong></td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated At</strong></td>
                                    <td>{{ $user->updated_at }}</td>
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
</x-app-layout>
