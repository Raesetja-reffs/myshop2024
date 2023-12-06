<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyPermission;
use App\Models\CompanyRole;

class CompanyPermissionController extends Controller
{
    /**
     * This function is used for show the set company permission page
     */
    public function setPermissions()
    {
        $data = CompanyRole::orderBy('strGroupName', 'asc')
            ->get();
        $companyRoles = [];
        if ($data) {
            foreach ($data as $record) {
                $companyRoles[$record['strGroupName']][] = $record;
            }
        }
        $companyPermissions = CompanyPermission::where('intCompanyId', 0)
            ->where('bitActive', 1)
            ->select('intCompanyRoleId')
            ->pluck('intCompanyRoleId')
            ->toArray();

        return view('company-permissions.set-permissions', compact('companyRoles', 'companyPermissions'));
    }

    /**
     * This function is used for save the company permissions
     */
    public function savePermissions(Request $request)
    {
        if ($request->has('companyRoles')) {
            foreach ($request->get('companyRoles') as $roleId => $value) {
                $isExist = CompanyPermission::where('intCompanyId', $request->get('intCompanyId'))
                    ->where('intCompanyRoleId', $roleId)
                    ->first();
                if ($isExist) {
                    $isExist->update(['bitActive' => $value]);
                } else {
                    CompanyPermission::create([
                        'intCompanyId' => $request->get('intCompanyId'),
                        'intCompanyRoleId' => $roleId,
                        'bitActive' => $value,
                    ]);
                }
            }
        }

        return redirect()->route('company-permissions.set-permissions')->with('success', 'Company Permissions has been successfully saved.');
    }
}
