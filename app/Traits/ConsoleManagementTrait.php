<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait ConsoleManagementTrait
{
    use ApiTrait;

    public function apiLogMessageAjax()
    {
        // $user = auth()->guard('central_api_user')->user();
        // $response = $this->httpRequest('post', 'general/getcustomers', [
        //     'userId' => $user->erp_user_id,
        //     'companyid' => $user->company_id,
        // ]);
        $response = [];

        return $response;
    }

    public function apiDeleteallLinesOnOrder($data)
    {
        $response = [
            [
                'Result' => 'SUCCESS'
            ]
        ];

        return $response;
    }
}
