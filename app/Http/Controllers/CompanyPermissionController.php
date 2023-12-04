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
        $companyRoles = CompanyRole::orderBy('strPermissionName', 'desc')->get();

        return view('company-permissions.set-permissions', compact('companyRoles'));
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
