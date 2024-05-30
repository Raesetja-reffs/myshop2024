<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait LoadingAppAPIsTrait
{
    use ApiTrait;

    public function apistockApi($data)
    {
        // $user = auth()->guard('central_api_user')->user();
        // $data['companyid'] = $user->company_id;
        // $data['UserID'] = $user->erp_user_id;
        // $response = $this->httpRequest('post', 'InsertNewOrder', $data);
        $response = 0;

        return $response;
    }
}
