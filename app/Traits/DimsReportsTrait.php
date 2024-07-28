<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait DimsReportsTrait
{
    use ApiTrait;

    public function apiBackordersandawaiting($data)
    {
        return $this->httpRequest('post', 'Post_BackOrderAndAwaitingStock', $data);
    }
    public function apiGetUserActionsByDateRange($data)
    {
        return $this->httpRequest('post', 'Post_GetUserActionsByDate', $data);
    }
    

    public function apiGetCustomerData()
    {

        return $this->httpRequest('post', 'Post_CustomersGridCustomers');
    }
    public function apiGetGroupData()
    {

        return $this->httpRequest('post', 'Post_CustomersGridGroups');
    }
    public function apiGetGroupSpecialDefaultPricesData($data)
    {

        return $this->httpRequest('post', 'Post_GetGroupSpecialDefaultData', $data);
    }
    public function apiGetSpecialDefaultPricesData($data)
    {

        return $this->httpRequest('post', 'Post_GetCustomerSpecialDefaultData', $data);
    }


}
