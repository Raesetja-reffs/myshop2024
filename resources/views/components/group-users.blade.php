<div data-repeater-item class="form-group flex-wrap align-items-start gap-5">
    <input type="hidden" name="group_user_id" value="{{ old('group_user_id', $groupUser['group_user_id']) }}" />
    <div class="row">
        <div class="col-md-6">
            <x-select-input
                name='user_id'
                :value="old('user_id', $groupUser['user_id'])"
                :options="$users"
                :messages="$errors->get('kt_docs_repeater_nested_outer.' . $key . '.user_id')"
                placeholder="Please select user name"
                required autofocus
                class="select2-with-dynamic-search"
                url="{{ route('central-users.get-search-users') }}"
            />
        </div>
        <div class="col-md-1">
            <a href="javascript:;" data-repeater-delete class="btn btn-icon btn-flex btn-danger hover-scale btn-sm btn-sm-icon">
                <i class="ki-outline ki-trash fs-1">
                </i>
            </a>
        </div>
    </div>
</div>
