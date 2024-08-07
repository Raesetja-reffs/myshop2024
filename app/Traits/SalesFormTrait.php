<?php

namespace App\Traits;

use App\Traits\UtilityTrait;

trait SalesFormTrait
{
    use UtilityTrait;

    public function apiGetSalesOrderPageData()
    {
        $response = $this->httpRequest('post', 'Get_apiGetSalesOrderPageData');
        if (isset($response['Table'])) {
            return [
                'getRoutes' => $this->convertToCollectionObject($this->convertToMultipleArray($response['Table'])),
                'deliverTypes' => $this->convertToMultipleArray($response['Table1']),
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
                'getDeliveryDates' => $this->convertToMultipleArray(isset($response['Table3']) ? $response['Table3'] : ['DeliveryDate' => date('Y-m-d')]),
                'getviewWareHouseLocations' => $this->convertToMultipleArray($response['Table4']),
                'saleman' => $this->convertToCollectionObject($this->convertToMultipleArray($response['Table5'])),
                'trueFalse' => $this->convertToMultipleArray($response['Table6']),
                'callListUserInfo' => $this->convertToCollectionObject($this->convertToMultipleArray($response['Table7'])),
                'callListDeliveryDate' => [
                    (object) [
                        'dteSessionDate' => $response['Table2']['dteSessionDate']
                    ]
                ],
            ];
        }

        return [];
    }

    public function apiGetSalesOrderCustomers($data)
    {
        return $this->httpRequest('post', 'searchcustomers', $data);
    }

    public function apiGetSalesOrderProducts($data)
    {
        return $this->httpRequest('post', 'searchProducts', $data, true);
    }

    public function apiGetSalesOrderProductsBasedOnCustomerCode($data)
    {
        return $this->httpRequest('post', 'searchProductsorderform', $data, true);
    }
}
