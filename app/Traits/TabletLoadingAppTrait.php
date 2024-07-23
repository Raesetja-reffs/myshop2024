<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait TabletLoadingAppTrait
{
    use ApiTrait;
    
    public function apiGetRoutes()
    {
        return $this->httpRequest('post','Post_GetRoutes'); //sp_API_GetRoutes
    }

    public function apiGetOrderTypes()
    {
        return $this->httpRequest('post','Post_GetOrderTypes'); //sp_API_GetOrderTypes
    }

    public function apiGetRoutePlannerStops($data)
    {
        return $this->httpRequest('post','Post_GetRoutePlannerStops', $data); //sp_API_R_getRoutePlannerStops
    }

    public function apiGetRouteMassAndValueOnPlanner($data)
    {
        return $this->httpRequest('post','Post_GetRouteMassAndValueOnPlanner', $data); //sp_API_R_GetRouteMassAndValueOnPlanner
    }

    public function apiMoveOrder($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post','Post_MoveOrder', $data); //sp_API_U_MoveOrder
    }

    public function apiSequenceStops($data)
    {
        return $this->httpRequest('post','Post_SequenceStops', $data); //sp_API_U_SequenceStops
    }

    public function apiGetBulkPickingGridData()
    {
        return $this->httpRequest('post','Post_GetBulkPickingGridData'); //sp_API_CR_BulkPickingGridView
    }
}