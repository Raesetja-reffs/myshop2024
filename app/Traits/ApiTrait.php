<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ApiTrait
{
    public function httpRequest($method, $url, $data = [])
    {
        $user = auth()->guard('central_api_user')->user();
        $response = Http::withHeaders([
            'Authorization' => 'Key=' . $user->erp_apiauthtoken,
        ])->$method($user->erp_apiurl . $url, $data);

        return $response->json();
    }
}
