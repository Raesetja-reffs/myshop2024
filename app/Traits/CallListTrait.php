<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait CallListTrait
{
    use ApiTrait;

    public function apiGetPhoneBook()
    {
        return $this->httpRequest('post', '');
    }
}
