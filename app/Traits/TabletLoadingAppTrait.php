<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait TabletLoadingAppTrait
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

    public function apiGetRoutePlannerStops($data)
    {
        return $this->httpRequest('post','Post_GetRoutePlannerStops', $data);
    }

    public function apiGetRouteMassAndValueOnPlanner($data)
    {
        return $this->httpRequest('post','Post_GetRouteMassAndValueOnPlanner', $data);
    }

    public function apiMoveOrder($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post','Post_MoveOrder', $data);
    }

    public function apiSequenceStops($data)
    {
        return $this->httpRequest('post','Post_SequenceStops', $data);
    }

    public function apiGetTabletLoading($data)
    {
        return $this->httpRequest('post','Post_GetTabletLoading', $data);
    }
}