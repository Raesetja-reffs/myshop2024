<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait WareHouseManagementControllerTrait
{
    use ApiTrait;

    public function apiMassProducts()
    {
        return $this->convertToMultipleArray($this->httpRequest('post', 'Post_tblPickingTeams'));
    }

    public function apiGetProductgriddata()
    {
        return $this->httpRequest('post', 'Post_RetreiveProductsGrid');
    }

    public function apiGetPushedAndProhibitedCustomers($data)
    {
        return $this->httpRequest('post', 'GetPushedAndProhibitedCustomers', $data);
    }

    public function apiPushAndProhibitProductForCustomers($data)
    {
        return $this->httpRequest('post', 'PushAndProhibitProductForCustomers', $data);
    }
}

