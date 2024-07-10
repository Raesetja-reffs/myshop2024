<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait DriversControllerTrait
{
    use ApiTrait;

    
    public function apiGetDeliveryAddressPreloadData()
    {
        $routes = $this->httpRequest('post', 'Post_CustomersGridRoutes');
        $customeradds = $this->httpRequest('post', 'Post_CustomerDeliveryAddresses');

        return [
            'customeradds' => $customeradds,
            'routes' => $routes,
        ];
    }
    public function apiUpdateDeliveryAddressInformation()
    {
        return $this->httpRequest('post', 'Post_UpdateCustomerDeliveryAddress', $data);
       
    }

}
