<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Traits\UtilityDependencyTrait;

trait ApiTrait
{
    use UtilityDependencyTrait;

    /**
     * This function is used for make the http request for the flowgear and handle the failed request
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @param bool $isConvertToMultiple
     */
    public function httpRequest($method, $url, $data = [], $isConvertToMultiple = false, $isMainUrl = false)
    {
        $returnResponse = [];
        try {
            $authToken = config('custom.MAIN_API_AUTHTOKEN');
            $baseURL = config('custom.MAIN_API_URL');
            if (!$isMainUrl) {
                $user = auth()->guard('central_api_user')->user();
                $data = $this->addAdditionalDetailsToApiData($user, $data);
                $data = $this->setBlankInsteadOfBlank($data);
                $authToken = $user->erp_apiauthtoken;
                $baseURL = $user->erp_apiurl;
            }
            $response = Http::withHeaders([
                'Authorization' => 'Key=' . $authToken,
            ])->$method($baseURL . $url, $data);
            $returnResponse = $response->json();
            if ($isConvertToMultiple) {
                $returnResponse = $this->convertToMultipleArray($returnResponse);
            }
            if (!$returnResponse) {
                $returnResponse = [];
            }
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
    private function addAdditionalDetailsToApiData($user, $data)
    {
        if (!isset($data['companyid'])) {
            $data['companyid'] = $user->company_id;
        }
        if (!isset($data['UserID'])) {
            $data['UserID'] = $user->erp_user_id;
        }

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

    /**
     * This function is used for set the blank value instead of null
     *
     * @param array $data
     */
    private function setBlankInsteadOfBlank($data)
    {
        if ($data) {
            foreach ($data as &$value) {
                if (!$value) {
                    $value = '';
                }
            }
        }

        return $data;
    }
}
