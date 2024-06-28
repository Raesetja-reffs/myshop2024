<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait WareHouseControllerTrait
{
    use ApiTrait;

    public function apiOnOrderAdvanced()
    {
        return $this->httpRequest('post', '');
    }
}
