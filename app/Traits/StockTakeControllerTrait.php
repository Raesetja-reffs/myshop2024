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

    public function apiGetProductData()
    {
        return $this->httpRequest('post', 'Post_GetProductData');
    }
    
    public function apiGetBinData()
    {
        return $this->httpRequest('post', 'Post_GetBinData');
    }
    public function apiSubmitMappedStockData($data)
    {
        return $this->httpRequest('post','Post_SubmitMappedStockData',$data);
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
