<?php

namespace App\Traits;

use App\Models\CentralUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiTrait;
use App\Models\CompanyPermission;
use Illuminate\Auth\Access\AuthorizationException;

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
        $companies = [];
        if (config('app.IS_API_BASED')) {
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
     * This function is used for get the companies list for dropdown
     *
     * @param array $data
     */
    public function deleteCentralDimsUser($data)
    {
        return $this->httpRequest('post', 'Post_DeleteALocalUser', $data, false, true);
    }

    /**
     * This function is used for check the company permission
     *
     * @param string $companyRoleSlug
     */
    public function checkCompanyPermission($companyRoleSlug)
    {
        if ($this->companyPermissions === null) {
            $companyId = '0';
            if (config('app.IS_API_BASED')) {
                $companyId = auth()->guard('central_api_user')->user()->company_id;
            }
            $this->companyPermissions = CompanyPermission::where('strCompanyId', $companyId)
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

    /**
     * This function is used for authorize the company permission
     *
     * @param string $companyRoleSlug
     */
    public function authorizeCompanyPermission($companyRoleSlug)
    {
        if (!$this->checkCompanyPermission($companyRoleSlug)) {
            $this->throwUnAuthorizationException();
        }
    }

    /**
     * This function is used for throw unauthorization exception
     *
     */
    public function throwUnAuthorizationException()
    {
        throw new AuthorizationException();
    }

    /**
     * This function is used for authorize the company permission
     *
     */
    public function authorizeUserIsSuperAdmin()
    {
        if (config('app.IS_API_BASED') && (!(auth()->guard('central_api_user')->user()->isSuperAdmin()))) {
            $this->throwUnAuthorizationException();
        }
    }

    /**
     * This function is used for get the central users list for dropdown
     *
     * @return array
     */
    public function getSearchCentralUserListForDropdown($searchString = '', $ids = [])
    {
        $applyOnlyUser = false;
        $users = CentralUser::select('id', 'username as name');
        if ($searchString != '') {
            $applyOnlyUser = true;
            $users = $users->where(function ($query) use ($searchString) {
                $query->orWhere('username', 'like', '%' . $searchString . '%');
            });
        }
        if (!empty($ids)) {
            $applyOnlyUser = true;
            $users = $users->whereIn('id', $ids);
        }
        if ($applyOnlyUser) {
            $users = $users->where('company_id', auth()->guard('central_api_user')->user()->company_id);
            $users = $users->orderBy('username', 'asc')->get();
        } else {
            $users = [];
        }

        return $users;
    }
}
