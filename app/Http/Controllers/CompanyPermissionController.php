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
        $data = CompanyRole::orderBy('strPermissionName', 'desc')->get();
        $companyRoles = [];
        if ($data) {
            foreach ($data as $record) {
                $companyRoles[$record['strGroupName']][] = $record;
            }
        }
        $companyPermissions = [];

        return view('company-permissions.set-permissions', compact('companyRoles', 'companyPermissions'));
    }

    /**
     * This function is used for save the company permissions
     */
    public function savePermissions()
    {
        $permissions = [];

        return view('company-permissions.show', compact('permissions'));
    }
}
