<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait LoadingAppAPIsTrait
{
    use ApiTrait;

    public function apistockApi($data)
    {
        return $this->httpRequest('post', 'Post_ProductSalesQuantity', $data);
    }
}
