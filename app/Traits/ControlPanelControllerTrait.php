<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait ControlPanelControllerTrait
{
    use ApiTrait;

    
    public function apiPickingTeamCRUD($data)
    {
        return $this->httpRequest('post', 'Post_CRUDPickingTeamData', $data);
       
    }

}
