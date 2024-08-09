<?php

namespace App\Traits;

use App\Traits\UtilityTrait;

trait TabletLoadingAppTrait
{
    use UtilityTrait;
    
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

        $queries = $this->httpRequest('post', 'Post_GetTabletLoading', $data);
        $queries = $this->convertToCollectionObject($queries);

        return $queries;
    }

    public function apiGetBulkPickingGridData($data)
    {
        return $this->httpRequest('post','Post_GetBulkPickingGridData',$data); //sp_API_CR_BulkPickingGridView
    }

    public function apiGetLogisticsPlan($data)
    {
        $queries = $this->httpRequest('post', 'Post_GetLogisticsPlan', $data);
        $queries = $this->convertToCollectionObject($queries);

        return $queries;
    }

    public function apiGetLogisticsPlannedRoutes($data)
    {
        $queries = $this->httpRequest('post', 'Post_GetLogisticsPlannedRoutes', $data);
        $queries = $this->convertToCollectionObject($queries);

        return $queries;
    }
}