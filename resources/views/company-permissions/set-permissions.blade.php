<x-app-layout>
    <x-slot name="header">
        {{ __('Company Permissions') }}
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
            Company Permissions </li>
        <!--end::Item-->
    </x-slot>
    <x-slot name="sidebaropen">
    </x-slot>
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <x-input-label class="mb-3" for="app_id" :value="__('App Role Selection')" />
                    <div class="row">
                        @if ($companyRoles->isEmpty())
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                No Company Role Found
                            </div>
                        @else
                            @foreach ($companyRoles as $companyRole)
                                <div class="col-3 mb-5">
                                    <div class="form-group">
                                        <x-input-label for="role{{ $companyRole->id }}">
                                            <input type="hidden" name="appRoles[{{ $companyRole->id }}]" value="0">
                                            <x-text-input id="role{{ $companyRole->id }}"
                                                name="appRoles[{{ $companyRole->id }}]" type="checkbox"
                                                class='form-check-input' :value="1" :checkboxValue="old(
                                                    'appRoles[{{ $companyRole->id }}]',
                                                    in_array($companyRole->id, $companyPermissions),
                                                )" required
                                                autofocus autocomplete="role{{ $companyRole->id }}" />
                                            <span></span>
                                            {{ $companyRole->strPermissionName }}
                                        </x-input-label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
