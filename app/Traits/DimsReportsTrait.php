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
}
