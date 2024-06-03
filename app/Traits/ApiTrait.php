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
}
