<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait GroupTrait
{
    use ApiTrait;

    public function apiGroupResource($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->convertToCollectionObject($this->httpRequest('post', 'Post_SettingsUserGroups', $data));
    }
}
