<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Traits\UtilityTrait;

trait ApiTrait
{
    use UtilityTrait;

    public function httpRequest($method, $url, $data = [])
    {
        $returnResponse = [];
        try {
            $user = auth()->guard('central_api_user')->user();
            $data = $this->addAdditionalDetailsToApiData($user, $data);
            $response = Http::withHeaders([
                'Authorization' => 'Key=' . $user->erp_apiauthtoken,
            ])->$method($user->erp_apiurl . $url, $data);
            $returnResponse = $response->json();
        } catch (Exception $e) {
            $logData = [
                'url' => $user->erp_apiurl . $url,
                'data' => $data,
                'key' => $user->erp_apiauthtoken,
                'error_message' => $e->getMessage(),
                'central_user_id' => $user->id,
            ];

            $this->saveDebugLog(config('custom.debug_log_message.flowgear_api'), $logData);
        }

        return $returnResponse;
    }

    /**
     * This function is used for setup the additional data to api data
     *
     * @param obj $user
     * @param array $data
     */
    public function addAdditionalDetailsToApiData($user, $data)
    {
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;

        return $data;
    }

    /**
     * This function is used for set the user name in api data
     *
     * @param array $data
     */
    public function setUserNameInApiData($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['Username'] = $user->erp_apiusername;

        return $data;
    }
}
