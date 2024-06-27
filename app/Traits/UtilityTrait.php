<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiTrait;
use App\Models\CompanyPermission;

trait UtilityTrait
{
    use ApiTrait;
    protected $companyPermissions = null;

    public function commonGetThings($thing, $groupId = null)
    {
        $things = 0;
        if (config('app.IS_API_BASED')) {
            $things = $this->apiGetThings([
                'Content' => $thing
            ]);
        } else {
            if (!$groupId) {
                $groupId = Auth::user()->GroupId;
            }
            $returnTrueOrFalse = DB::connection('sqlsrv3')
                ->select("select [dbo].[fnGetGroupThings](" . $groupId . ",'" . $thing . "',0) as things");
            foreach ($returnTrueOrFalse as $val) {
                $things = $val->things;
            }
        }

        return $things;
    }

    public function apiOrdersExport($data)
    {
        return $this->httpRequest('post', 'Post_RetrieveOrderLineForExcel', $data);
    }

    /**
     * This function is used for convert the array to collection object
     *
     * @param array $data
     */
    public function convertToCollectionObject($data)
    {
        return collect($data)->map(function ($item) {
            return (object) $item;
        });
    }

    /**
     * This function is used for return the success response
     */
    public function successResponse()
    {
        return response()->json(['status' => 'success']);
    }

    /**
     * This function is used for call the get thing api
     *
     * @param array $data
     */
    public function apiGetThings($data)
    {
        return $this->httpRequest('post', 'Post_GetThings', $data);
    }

    /**
     * This function is used for get the companies list for dropdown
     */
    public function getCompaniesListForDropdown()
    {
        $companies = $this->httpRequest('get', 'GetcompaniesAndGuid', [], false, true);
        if ($companies) {
            foreach ($companies as &$company) {
                $company['id'] = $company['strGUID'];
                $company['name'] = $company['strCompanyName'];
            }
            $companies[] = [
                'id' => '5730aaa7-fd77-e46f-298d',
                'name' => 'Linx Demo2'
            ];
            $companies[] = [
                'id' => '5730aaa7-fd77-e46f-300d',
                'name' => 'Linx Demo3'
            ];
        }

        return $companies;
    }

    /**
     * This function is used for get the companies list for dropdown
     *
     * @param array $data
     */
    public function createCentralDimsUser($data)
    {
        return $this->httpRequest('post', 'Post_CreateDimsUser', $data, false, true);
    }

    /**
     * This function is used for check the company permission
     * @param string $companyRoleSlug
     */
    public function checkCompanyPermission($companyRoleSlug)
    {
        if ($this->companyPermissions === null) {
            $this->companyPermissions = CompanyPermission::where('intCompanyId', 0)
                ->where('bitActive', 1)
                ->join('tblCompanyRoles', 'tblCompanyRoles.intAutoId', '=', 'tblCompanyPermissions.intCompanyRoleId')
                ->select('tblCompanyRoles.strSlug', 'tblCompanyPermissions.bitActive')
                ->pluck('bitActive', 'strSlug')
                ->toArray();
        }

        if (isset($this->companyPermissions[$companyRoleSlug]) && $this->companyPermissions[$companyRoleSlug] == 1) {
            return true;
        }

        return false;
    }
}
