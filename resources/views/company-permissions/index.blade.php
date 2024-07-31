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
                    @if (config('app.IS_API_BASED'))
                        <div class="mb-3">
                            <x-input-label for="company_id" :value="__('Company Name')" class="required" />
                            <x-select-input id='company_id'
                                name='company_id'
                                :value="old('company_id', request()->get('company_id'))"
                                :options="$companies"
                                :messages='$errors->get("company_id")'
                                placeholder="Please select company"
                                required autofocus autocomplete='company_id'
                                class="company_app_role_dropdown"
                            />
                            <input type="hidden" id="company_name" name="company_name" value="{{ old('company_name') }}" />
                        </div>
                    @endif
                    <div class="get-roles-html mb-4"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var companyPermissionGetRoleUrl = "{{ route('company-permissions.get-roles', ['companyId' => request()->get('company_id', 0)]) }}";
        $(document).ready(function() {
            if ($('.company_app_role_dropdown').length > 0) {
                loadCompanyRole($('.company_app_role_dropdown').val());
                $(document).on('change', '.company_app_role_dropdown', function(e) {
                    loadCompanyRole($(this).val());
                });
            } else {
                loadCompanyRole(0);
            }
        });
        function loadCompanyRole(companyId)
        {
            if (companyId == '') {
                companyId = 0;
            }
            showLoader();
            let segments = companyPermissionGetRoleUrl.split('/');
            segments.pop();
            segments.push(companyId);
            let newUrl = segments.join('/');
            $.ajax({
                url: newUrl,
                success: function(data) {
                    $(".get-roles-html").html(data);
                }
            });
        }
    </script>
</x-app-layout>
