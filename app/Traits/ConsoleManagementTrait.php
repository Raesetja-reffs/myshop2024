<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait ConsoleManagementTrait
{
    use ApiTrait;

    public function apiLogMessageAjax()
    {
        return [];
    }

    public function apiDeleteallLinesOnOrder($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_DeleteAllLinesOnOrder', $data);
    }
}
