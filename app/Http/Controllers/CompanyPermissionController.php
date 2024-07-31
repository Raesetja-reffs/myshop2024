<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyPermission;
use App\Models\CompanyRole;
use App\Traits\UtilityTrait;

class CompanyPermissionController extends Controller
{
    use UtilityTrait;

    public function index()
    {
        $companies = $this->getCompaniesListForDropdown();

        return view('company-permissions.index', compact('companies'));
    }

    /**
     * This function is used for show the set company permission page
     */
    public function getRoles($companyId = 0)
    {
        $companyRoles = [];
        $companyPermissions = [];
        $companies = [];
        if (!(config('app.IS_API_BASED') && $companyId == 0)) {

            $data = CompanyRole::orderBy('strGroupName', 'asc')
                ->get();
            if ($data) {
                foreach ($data as $record) {
                    $companyRoles[$record['strGroupName']][] = $record;
                }
            }
            $companyPermissions = CompanyPermission::where('intCompanyId', $companyId)
                ->where('bitActive', 1)
                ->select('intCompanyRoleId')
                ->pluck('intCompanyRoleId')
                ->toArray();
            $companies = $this->getCompaniesListForDropdown();
        }

        return view('company-permissions.get-roles', compact('companyRoles', 'companyPermissions', 'companies', 'companyId'));
    }

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
        $companies = $this->getCompaniesListForDropdown();

        return view('company-permissions.set-permissions', compact('companyRoles', 'companyPermissions', 'companies'));
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
