<?php

namespace App\Traits;

use App\Traits\ApiTrait;
use App\Traits\UtilityTrait;

trait RouteOptimizationTrait
{
    use ApiTrait;
    use UtilityTrait;

    public function apiGetRoutes()
    {
        return $this->convertToCollectionObject($this->httpRequest('post','Post_GetRoutes'));
    }

    public function apiGetOrderTypes()
    {
        return $this->convertToCollectionObject($this->httpRequest('post','Post_GetOrderTypes'));
    }

    public function apiGetRoutesToOptimize($data)
    {
        return $this->httpRequest('post','Post_GetRoutesToOptimize', $data);
    }

    public function apiGetCompanyThings($data)
    {
        return $this->convertToCollectionObject($this->httpRequest('post','Post_GetCompanyThings', $data));
    }

    public function apiUpdateCustomerGeoCoordinates($data)
    {
        $data = $this->setUserNameInApiData($data);
        return $this->httpRequest('post','Post_UpdateCustomerGeoCoordinates', $data);
    }

    public function apiLogRouteOptimizationUsage($data)
    {
        $data = $this->setUserNameInApiData($data);
        return $this->httpRequest('post','Post_LogRouteOptimizationUsage', $data);
    }

    public function apiGetLiveDriversAppInfo($data)
    {
        return $this->convertToCollectionObject($this->httpRequest('post','Post_GetLiveDriversAppInfo', $data));
    }

    

}
