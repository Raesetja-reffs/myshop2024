<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait WareHouseManagementControllerTrait
{
    use ApiTrait;

    public function apiMassProducts()
    {
        return $this->httpRequest('post', '');
    }
}
