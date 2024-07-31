@if (config('app.IS_API_BASED') && $companyId == 0)
    <x-input-label for="app_id" :value="__('Please select the company')" class="mb-3 fw-bold" />
@else
    @if (count($companyRoles) == 0)
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center">
                No Company Role Found
            </div>
        </div>
    @else
        <x-input-label for="app_id" :value="__('Role Selection')" class="mb-3 fw-bold" />
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
                                    <input type="hidden" name="companyRoles[{{ $companyRole->intAutoId }}]" value="0">
                                    <x-text-input id="role{{ $companyRole->intAutoId }}"
                                        name="companyRoles[{{ $companyRole->intAutoId }}]" type="checkbox"
                                        class='form-check-input custom-checkbox-sm d-flex align-items-center me-1'
                                        :value="1" :checkboxValue="old(
                                            'companyRoles[{{ $companyRole->intAutoId }}]',
                                            in_array($companyRole->intAutoId, $companyPermissions),
                                        )" autofocus
                                    />
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
@endif
