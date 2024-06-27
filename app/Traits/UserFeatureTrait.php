<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait UserFeatureTrait
{
    use ApiTrait;

    public function apiGetDimsUsers()
    {
        return $this->httpRequest('post', 'Post_GetDimsUsers');
    }
}
