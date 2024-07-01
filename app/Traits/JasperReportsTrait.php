<?php

namespace App\Traits;

use App\Traits\UtilityTrait;

trait JasperReportsTrait
{
    use UtilityTrait;

    public function apiPDFOrders($data)
    {
        $companyHeader = $this->httpRequest('post', 'Pdf_RetrieveOrderHeaderPrint', $data);
        $companyInfo = $this->httpRequest('post', 'Pdf_StaticCompanyInfoHeader', $data);

        return [
            'orderheader' => $this->convertToCollectionObject($companyHeader),
            'companyInfo' => $this->convertToCollectionObject($companyInfo),
        ];
    }

    public function apiGetOrderLines($data)
    {
        return $this->convertToCollectionObject($this->httpRequest('post', 'Pdf_RetrieveLines', $data));
    }
}
