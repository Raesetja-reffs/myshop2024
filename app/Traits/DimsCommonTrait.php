<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait DimsCommonTrait
{
    use ApiTrait;

    public function apiInvoiceLookup($searchString)
    {
        // $user = auth()->guard('central_api_user')->user();
        // $response = $this->httpRequest('post', 'general/getcustomers', [
        //     'userId' => $user->erp_user_id,
        //     'companyid' => $user->company_id,
        // ]);
        $response =  [
            [
                "id" => "366724",
                "value" => "CAN366724",
                "StoreName" => "000017Customer",
                "CustomerPastelCode" => "000017",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "2"
            ],
            [
                "id" => "360086",
                "value" => "CAN360086",
                "StoreName" => "N00163Customer",
                "CustomerPastelCode" => "N00163",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "2"
            ],
            [
                "id" => "360120",
                "value" => "CAN360120",
                "StoreName" => "000303Customer",
                "CustomerPastelCode" => "000303",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "2"
            ],
            [
                "id" => "367187",
                "value" => "CAN367187",
                "StoreName" => "COD2177Customer",
                "CustomerPastelCode" => "COD2177",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "0"
            ],
            [
                "id" => "365791",
                "value" => "CAN365791",
                "StoreName" => "COD621Customer",
                "CustomerPastelCode" => "COD621",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "0"
            ],
            [
                "id" => "377497",
                "value" => "CAN377497",
                "StoreName" => "COD2218Customer",
                "CustomerPastelCode" => "COD2218",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "0"
            ],
            [
                "id" => "365464",
                "value" => "CAN365464",
                "StoreName" => "COD2519Customer",
                "CustomerPastelCode" => "COD2519",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "0"
            ],
            [
                "id" => "372278",
                "value" => "CAN372278",
                "StoreName" => "000063Customer",
                "CustomerPastelCode" => "000063",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "2"
            ],
            [
                "id" => "375554",
                "value" => "CAN375554",
                "StoreName" => "000095Customer",
                "CustomerPastelCode" => "000095",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "2"
            ],
            [
                "id" => "377944",
                "value" => "CAN377944",
                "StoreName" => "000063Customer",
                "CustomerPastelCode" => "000063",
                "CompanyName" => "Margot Swiss",
                "mnyTotal" => ".0000",
                "PaymentTerms" => "2"
            ]
        ];

        return $response;
    }

    public function apiChangerouteonorder($data)
    {
        $response = 'BEAUFORT WEST';

        return $response;
    }

    public function apiChangesalesman($data)
    {
        return 'Sorry ,you don\'t have access to authorize accounts';
    }

    public function apiVerifyAuth($data)
    {
        return [];
    }

    public function apiClearorderlocksperorder($data)
    {
        return [];
    }

    public function apiInvoicedoc()
    {
        return [];
    }

    public function apiCheckifhasmultiaddress($data)
    {
        $response = [
            [
                'result' => 'SUCCESS'
            ]
        ];

        return $response;
    }
}
