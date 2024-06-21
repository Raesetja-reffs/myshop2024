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
}
