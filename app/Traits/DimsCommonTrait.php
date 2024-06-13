<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait DimsCommonTrait
{
    use ApiTrait;

    public function apiInvoiceLookup($data)
    {
        return $this->httpRequest('post', 'Post_InvoiceLookUp', $data);
    }

    public function apiChangerouteonorder($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_ChangeRouteOnOrder', $data);
    }

    public function apiChangesalesman($data)
    {
        return $this->httpRequest('post', 'Post_ChangeSalesman', $data);
    }

    public function apiVerifyAuth($data)
    {
        return $this->httpRequest('post', 'Post_GeneralUsernamePasswordAuth', $data);
    }

    public function apiClearorderlocksperorder($data)
    {
        return $this->httpRequest('post', 'Post_DeleteOrderLocksPerUser', $data);
    }

    public function apiInvoicedoc($data)
    {
        return $this->httpRequest('post', 'Post_PrintInvoice', $data);
    }

    public function apiCheckifhasmultiaddress($data)
    {
        return $this->httpRequest('post', 'Post_HasMultiDeliveryAddress', $data);
    }

    public function apiAuthBulkZeroCost($data)
    {
        return [
            'done' => 'Sorry ,you don\'t have access to authorize accounts',
            'result' => []
        ];
    }

    public function apiVerifyAuthOnAdmin($data)
    {
        return [];
    }
}
