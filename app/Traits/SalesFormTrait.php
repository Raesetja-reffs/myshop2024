<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;

trait SalesFormTrait
{
    public function getCustomer()
    {
        $user = auth()->guard('central_api_user')->user();
        $response = Http::withHeaders([
            'Authorization' => 'Key=' . $user->erp_apiauthtoken,
        ])->post($user->erp_apiurl . 'general/getcustomers', [
            'userId' => $user->erp_user_id,
            'companyid' => $user->company_id,
        ]);

        return $response->json();
    }
}
