<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait JasperReportsTrait
{
    use ApiTrait;

    public function apiPDFOrders()
    {
        return [
            'orderheader' => [
                (object) [
                    "CustomerNumber" => "000017",
                    "SoldTo" => "000017Customer
                        Del Address 1
                        Del Address 2",
                    "ShipTo" => "000017Customer
                        Del Address 1
                        Del Address 2",
                    "DocNumber" => "366724",
                    "DocDate" => "2020-03-26 00:00:00.000",
                    "DIMS_OrderNo" => "Mariena",
                    "strCurrency" => "R",
                    "subtotal" => ".00",
                    "Total" => ".00",
                    "tax" => ".00"
                ]
            ],
            'companyInfo' => [
                (object) [
                    "intAutoReportID" => "1",
                    "strHtmlHeader" => "",
                    "strFormName" => "HeaderFooter",
                    "dtm" => "2023-03-10 15:24:30.800",
                    "intOwnerID" => "1",
                    "strHtmlFooter" => "<h5>Footer</h5>"
                ]
            ],
        ];
    }

    public function apiPDFDelDate()
    {
        return [
            'orderheader' => [
                (object) [
                    "CustomerNumber" => "000017",
                    "SoldTo" => "000017Customer
                        Del Address 1
                        Del Address 2",
                    "ShipTo" => "000017Customer
                        Del Address 1
                        Del Address 2",
                    "DocNumber" => "366724",
                    "DocDate" => "2020-03-26 00:00:00.000",
                    "DIMS_OrderNo" => "Mariena",
                    "strCurrency" => "R",
                    "subtotal" => ".00",
                    "Total" => ".00",
                    "tax" => ".00"
                ]
            ],
            'companyInfo' => [
                (object) [
                    "intAutoReportID" => "1",
                    "strHtmlHeader" => "",
                    "strFormName" => "HeaderFooter",
                    "dtm" => "2023-03-10 15:24:30.800",
                    "intOwnerID" => "1",
                    "strHtmlFooter" => "<h5>Footer</h5>"
                ]
            ],
        ];
    }
}
