<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait SalesFormTrait
{
    use ApiTrait;

    public function apiGetSalesOrderPageData()
    {
        $response = $this->httpRequest('post', 'Get_apiGetSalesOrderPageData');

        return [
            'getRoutes' => $this->convertToCollectionObject($response['Table']),
            'deliverTypes' => $response['Table1'],
            'userPerfomance' => [
                (object) [
                    'NoOfOrders' => $response['Table2']['NoOfOrders'],
                    'OrderValue' => $response['Table2']['OrderValue'],
                    'AvgOrderValue' => $response['Table2']['AvgOrderValue'],
                ],
            ],
            'getLastInserted' => [
                [
                    "DeliveryDate" => $response['Table2']['LastDeliveryDate'],
                    "OrderId" => $response['Table2']['OrderId'],
                    "OrderDate" => $response['Table2']['OrderDate'],
                ]
            ],
            'marginType' => [
                (object) [
                    "ReportType" => $response['Table2']['ReportType'],
                    "Comment" => $response['Table2']['Comment'],
                ]
            ],
            'printinvoices' => $response['Table2']['AllowPrintInvoices'],
            'getDeliveryDates' => $response['Table3'],
            'getviewWareHouseLocations' => $response['Table4'],
            'saleman' => $this->convertToCollectionObject($response['Table5']),
            'trueFalse' => $response['Table6'],
            'callListUserInfo' => $this->convertToCollectionObject($response['Table7']),
            'callListDeliveryDate' => [
                (object) [
                    'dteSessionDate' => $response['Table2']['dteSessionDate']
                ]
            ],
        ];
    }

    public function apiGetSalesOrderCustomers($data)
    {
        return $this->httpRequest('post', 'searchcustomers', $data);
    }

    public function apiGetSalesOrderProducts($data)
    {
        return $this->httpRequest('post', 'searchProducts', $data, true);
    }
}
