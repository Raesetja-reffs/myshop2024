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
                    @if (count($companyRoles) == 0)
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                No Company Role Found
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('company-permissions.save-permissions') }}">
                            @csrf

                            <input type="hidden" name="intCompanyId" value="0">

                            @foreach ($companyRoles as $name => $group)
                                <div class="row">
                                    <x-input-label class="mb-3 fw-bold" for="" :value="__($name)" />
                                    @foreach ($group as $companyRole)
                                        <div class="col-3 mb-5">
                                            <div class="form-group">
                                                <x-input-label for="role{{ $companyRole->intAutoId }}" class="d-flex align-items-center">
                                                    <input type="hidden" name="companyRoles[{{ $companyRole->intAutoId }}]"
                                                        value="0">
                                                    <x-text-input id="role{{ $companyRole->intAutoId }}"
                                                        name="companyRoles[{{ $companyRole->intAutoId }}]"
                                                        type="checkbox"
                                                        class='form-check-input custom-checkbox-sm d-flex align-items-center me-1'
                                                        :value="1"
                                                        :checkboxValue="old(
                                                            'companyRoles[{{ $companyRole->intAutoId }}]',
                                                            in_array($companyRole->intAutoId, $companyPermissions),
                                                        )"
                                                        autofocus autocomplete="role{{ $companyRole->intAutoId }}" />
                                                    <span></span>
                                                    {{ $companyRole->strPermissionName }}
                                                </x-input-label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="flex items-center gap-4">
                                <x-primary-button class="btn-sm">
                                    {{ __('Save') }}
                                </x-primary-button>
                                <x-a-secondary-button class="btn-sm" href="{{ route('home') }}">{{ __('Cancel') }}</x-a-secondary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
