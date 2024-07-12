<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait StockTakeControllerTrait
{
    use ApiTrait;

    public function apiGetStockTakeUsers()
    {
        return $this->httpRequest('post','Post_RetrieveStockTakeUsers');
    }
    
    public function apiGetStockTakes($data)
    {
        return $this->httpRequest('post','Post_GetStockTakeData',$data);
    }

    public function apiCreateStockTake($data)
    {
        return $this->httpRequest('post','Post_CreateStockTake',$data);
    }
    public function apiUpdateStockTakeUsers($data)
    {
        return $this->httpRequest('post','Post_UpdateStocktakeTeamName',$data);
    }
    public function apiGetReferenceData($data)
    {
        return $this->httpRequest('post','Post_GetStockTakeDataOnName',$data);
    }

    
    public function apiGetAssignMappingData($data)
    {
        return $this->httpRequest('post','Post_GetAssignMappingData',$data);
    }
    
    public function apiGetMappedData($data)
    {
        return $this->httpRequest('post','Post_GetMappedData',$data);
    }

    /*
    public function apiPickingTeamCRUD($data)
    {
        return $this->httpRequest('post', 'Post_CRUDPickingTeamData', $data);
       
    }*/

}
