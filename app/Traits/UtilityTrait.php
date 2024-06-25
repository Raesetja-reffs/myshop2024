<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiTrait;

trait UtilityTrait
{
    use ApiTrait;
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
}
