<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Group') }}
    </x-slot>
    <x-slot name="breadcrum">
        <!--begin::Item-->
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
        <li class="breadcrumb-item text-dark">Edit Group </li>
    </x-slot>
    <div class="card mb-2 mt-2">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('groups.update', $group->intGroupId) }}" class="addnovalidate" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <x-input-label for="strGroupName" :value="__('Group Name')" class="required" />
                                    <x-text-input id="strGroupName"
                                        name="strGroupName"
                                        type="text"
                                        class="form-control"
                                        :value="old('strGroupName', $group->strGroupName)"
                                        :messages="$errors->get('strGroupName')"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="strGroupDescription" :value="__('Group Description')" />
                                    <x-text-area id="strGroupDescription"
                                        name="strGroupDescription"
                                        type="text"
                                        class="form-control"
                                        :value="old('strGroupDescription', $group->strGroupDescription)"
                                        :messages="$errors->get('strGroupDescription')"
                                        required
                                    />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="group_users" :value="__('Group Users')" class="mb-3" />
                                    <!--begin::Repeater-->
                                    <div id="kt_docs_repeater_nested">
                                        <!--begin::Form group-->
                                        <div class="form-group">
                                            <div data-repeater-list="kt_docs_repeater_nested_outer" class="d-flex flex-column gap-3">
                                                @if (old('kt_docs_repeater_nested_outer', $groupUsers))
                                                    @foreach (old('kt_docs_repeater_nested_outer', $groupUsers) as $key => $groupUser)
                                                        @isset($groupUser->id)
                                                            @php $groupUser->group_user_id = $groupUser->id; @endphp
                                                        @endisset
                                                        <x-group-users :key="$key" :users="$users" :groupUser="$groupUser" />
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <!--begin::Form group-->
                                        <div class="form-group mt-5 mb-5">
                                            <a href="javascript:;" data-repeater-create class="btn btn-flex btn-light-primary">
                                                <i class="ki-outline ki-plus fs-3"></i>
                                                Add New Group User
                                            </a>
                                        </div>
                                        <!--end::Form group-->
                                    </div>
                                    <!--end::Repeater-->
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button class="btn-sm">{{ __('Update') }}</x-primary-button>
                                    <x-a-secondary-button class="btn-sm" href="{{ route('groups.index') }}">{{ __('Cancel') }}</x-a-secondary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                removeSelect2WithDynamicSearch();
                $('#kt_docs_repeater_nested').repeater({
                    show: function () {
                        $(this).slideDown();
                        select2WithDynamicSearch();
                    },
                    hide: function (deleteElement) {
                        $(this).slideUp(deleteElement);
                    }
                });
                select2WithDynamicSearch();
            });
        </script>
    @endpush
</x-app-layout>
