<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait ConsoleManagementTrait
{
    use ApiTrait;

    public function apiLogMessageAjax()
    {
        return [];
    }

    public function apiDeleteallLinesOnOrder($data)
    {
        return [
            [
                'Result' => 'SUCCESS'
            ]
        ];
    }
}
