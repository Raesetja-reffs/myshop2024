<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait SalesFormFunctionsTrait
{
    use ApiTrait;

    public function apiInsertOrderHearder($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;
        $response = $this->httpRequest('post', 'InsertNewOrder', $data);

        return $response;
    }

    public function apiReturnProductPrice($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;
        //$response = $this->httpRequest('post', 'InsertNewOrder', $data);
        $response = [];

        return $response;
    }

    public function apiAssociatedItem($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;
        //$response = $this->httpRequest('post', 'InsertNewOrder', $data);
        $response = [];

        return $response;
    }
}
