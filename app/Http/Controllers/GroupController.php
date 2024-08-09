<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UtilityTrait;
use App\Traits\GroupTrait;
use App\Http\Requests\StoreGroupRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\GroupUser;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use UtilityTrait, GroupTrait;

    /**
     * This function is used for show the set company permission page
     */
    public function index(Request $request)
    {
        $this->authorizeUserIsSuperAdmin();
        $pageSize = config('custom.pagination');
        $pageNumber = 1;
        if ($request->has('page') && $request->input('page')) {
            $pageNumber = $request->input('page');
        }
        $passData = [
            'intGroupId' => 0,
            'StatementType' => 'Select'
        ];
        $groups = $this->apiGroupResource($passData);
        $groupIds = [];
        if ($groups) {
            foreach ($groups as $group) {
                $groupIds[] = $group->intGroupId;
            }
        }
        $groupWiseNoOfUsers = [];
        if (!empty($groupIds)) {
            $groupWiseNoOfUsers = GroupUser::whereIn('intGroupId', $groupIds)
                ->select(DB::raw('COUNT(*) as total'), 'intGroupId')
                ->groupBy('intGroupId')
                ->get();
            $groupWiseNoOfUsers = $groupWiseNoOfUsers->groupBy('intGroupId');
        }
        $total = count($groups);

        $groups = new LengthAwarePaginator(
            $groups,
            $total,
            $pageSize,
            $pageNumber,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('groups.index', compact('groups', 'groupWiseNoOfUsers'));
    }

    /**
     * This function is used for shwo the create user page
     */
    public function create()
    {
        $this->authorizeUserIsSuperAdmin();
        $groupUsers = collect();
        $groupUsers->push([
            'group_user_id' => '',
            'user_id' => '',
        ]);
        $userIds = [];
        if (old('kt_docs_repeater_nested_outer')) {
            foreach (old('kt_docs_repeater_nested_outer') as $value) {
                $userIds[] = $value['user_id'];
            }
        }
        $users = [];
        if ($userIds) {
            $users = $this->getSearchCentralUserListForDropdown('', $userIds);
        }

        return view('groups.create', compact('groupUsers', 'users'));
    }

    /**
     * This function is used for save the create user
     */
    public function store(StoreGroupRequest $request)
    {
        $this->authorizeUserIsSuperAdmin();
        $data = $request->validated();
        $passData = [
            'intGroupId' => 0,
            'strGroupName' => $data['strGroupName'],
            'strGroupDescription' => $data['strGroupDescription'],
            'StatementType' => 'Insert'
        ];
        $group = $this->apiGroupResource($passData);
        if (isset($group[0]->Result) && $group[0]->Result == 'SUCCESS') {
            $this->saveGroupUsers($request, $group[0]->intGroupId);
        }

        return redirect()->route('groups.index')->with('success', 'Group' . config('custom.flash_messages')['create']);
    }

    /**
     * This function is used for show the user details
     */
    public function show($groupId)
    {
        $this->authorizeUserIsSuperAdmin();
        $passData = [
            'intGroupId' => $groupId,
            'strGroupName' => '',
            'strGroupDescription' => '',
            'StatementType' => 'ShowGroup'
        ];
        $groupData = $this->apiGroupResource($passData);
        if (isset($groupData[0])) {
            $group = $groupData[0];
            $userIds = [];
            $groupUsers = GroupUser::where('intGroupId', $groupId)
                ->get();
            if (!$groupUsers->isEmpty()) {
                foreach ($groupUsers as $groupUser) {
                    $userIds[] = $groupUser->user_id;
                }
            }
            $users = [];
            if ($userIds) {
                $users = $this->getSearchCentralUserListForDropdown('', $userIds);
                $users = $users->groupBy('id');
            }

            return view('groups.show', compact('group', 'groupUsers', 'users'));
        }
    }

    /**
     * This function is used for show the edit group page
     */
    public function edit($groupId)
    {
        $this->authorizeUserIsSuperAdmin();
        $passData = [
            'intGroupId' => $groupId,
            'strGroupName' => '',
            'strGroupDescription' => '',
            'StatementType' => 'ShowGroup'
        ];
        $groupData = $this->apiGroupResource($passData);
        if (isset($groupData[0])) {
            $group = $groupData[0];
            $userIds = [];
            $groupUsers = GroupUser::where('intGroupId', $groupId)
                ->get();
            if ($groupUsers->isEmpty()) {
                $groupUsers->push([
                    'group_user_id' => '',
                    'user_id' => '',
                ]);
            } else {
                foreach ($groupUsers as $groupUser) {
                    $userIds[] = $groupUser->user_id;
                }
            }
            if (old('kt_docs_repeater_nested_outer')) {
                foreach (old('kt_docs_repeater_nested_outer') as $value) {
                    $userIds[] = $value['user_id'];
                }
            }
            $users = [];
            if ($userIds) {
                $users = $this->getSearchCentralUserListForDropdown('', $userIds);
            }

            return view('groups.edit', compact('group', 'groupUsers', 'users'));
        }
    }

    /**
     * This function is used for save the update group
     */
    public function update(StoreGroupRequest $request, $groupId)
    {
        $this->authorizeUserIsSuperAdmin();
        $this->authorizeUserIsSuperAdmin();
        $data = $request->validated();
        $passData = [
            'intGroupId' => $groupId,
            'strGroupName' => $data['strGroupName'],
            'strGroupDescription' => $data['strGroupDescription'],
            'StatementType' => 'Update'
        ];
        $group = $this->apiGroupResource($passData);
        if (isset($group[0]->Result) && $group[0]->Result == 'SUCCESS') {
            $this->saveGroupUsers($request, $group[0]->intGroupId);
        }

        return redirect()->route('groups.index')->with('success', 'Group' . config('custom.flash_messages')['update']);
    }

    /**
     * This function is used for destroy the report builder file
     */
    public function destroy($groupId)
    {
        $this->authorizeUserIsSuperAdmin();
        $passData = [
            'intGroupId' => $groupId,
            'strGroupName' => '',
            'strGroupDescription' => '',
            'StatementType' => 'Delete'
        ];
        $group = $this->apiGroupResource($passData);
        if (isset($group[0]->Result) && $group[0]->Result == 'SUCCESS') {

            return redirect()->route('groups.index')->with('success', 'Group' . config('custom.flash_messages')['delete']);
        }

        return redirect()->route('groups.index')->with('success', config('custom.flash_messages')['error_contact_to_administrator']);
    }

    /**
     * This function is used for save the group users
     *
     * @param obj $request
     * @param int $groupId
     */
    private function saveGroupUsers($request, $groupId)
    {
        $groupUserIds = [];
        if ($request->get('kt_docs_repeater_nested_outer')) {
            foreach ($request->get('kt_docs_repeater_nested_outer') as $groupUser) {
                if ($groupUser['user_id'] != '') {
                    $groupUserData = [
                        'intGroupId' => $groupId,
                        'user_id' => $groupUser['user_id'],
                    ];
                    $groupUserModel = null;
                    if ($groupUser['group_user_id']) {
                        $groupUserModel = GroupUser::where('id', $groupUser['group_user_id'])->first();
                        $groupUserModel->update($groupUserData);
                    } else {
                        $groupUserModel = GroupUser::create($groupUserData);
                    }
                    $groupUserIds[] = $groupUserModel->id;
                }
            }
        }
        GroupUser::where('intGroupId', $groupId)
            ->whereNotIn('id', $groupUserIds)
            ->delete();
    }
}
