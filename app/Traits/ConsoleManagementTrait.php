<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait ConsoleManagementTrait
{
    use ApiTrait;

    public function apiLogMessageAjax($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['LoggedBy'] = $user->erp_apiusername;

        return $this->httpRequest('post', 'Post_ConsoleManagement', $data);
    }

    public function apiDeleteallLinesOnOrder($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_DeleteAllLinesOnOrder', $data);
    }
}
