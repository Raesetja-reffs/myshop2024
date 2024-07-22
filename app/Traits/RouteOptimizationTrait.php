<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait RouteOptimizationTrait
{
    use ApiTrait;

    public function apiGetRoutes()
    {
        return $this->httpRequest('post','Post_GetRoutes');
    }

    public function apiGetOrderTypes()
    {
        return $this->httpRequest('post','Post_GetOrderTypes');
    }

    public function apiGetRoutesToOptimize($data)
    {
        return $this->httpRequest('post','Post_GetRoutesToOptimize', $data);
    }

    public function apiGetCompanyThings($data)
    {
        return $this->httpRequest('post','Post_GetCompanyThings', $data);
    }

    public function apiUpdateCustomerGeoCoordinates($data)
    {
        $data = $this->setUserNameInApiData($data);
        return $this->httpRequest('post','Post_UpdateCustomerGeoCoordinates', $data);
    }

    

}
