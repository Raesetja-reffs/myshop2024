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
                    'OrderValue' => null,
                    'AvgOrderValue' => null,
                ],
            ],
            'getLastInserted' => [
                [
                    "DeliveryDate" => $response['Table2']['LastDeliveryDate'],
                    "OrderId" => "360046",
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
        ];
    }

    public function apiCallListUserInfo()
    {
        $response = [
            [
                "Routeid" => "10",
                "Route" => "GEORGE",
                "od" => "2",
                "dteSessionDate" => "2022-07-15"
            ],
            [
                "Routeid" => "1",
                "Route" => "No Route",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "2",
                "Route" => "BEAUFORT WEST",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "3",
                "Route" => "MOSSELBAY 1",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "4",
                "Route" => "MOSSELBAY 2",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "5",
                "Route" => "COLLECTIONS",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "6",
                "Route" => "COURIER",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "10",
                "Route" => "GEORGE",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "13",
                "Route" => "JEFFREYS BAY",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "14",
                "Route" => "KNYNSA",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "15",
                "Route" => "OUDTSHOORN",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "16",
                "Route" => "PLETTENBERG BAY",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "17",
                "Route" => "RIVERSDALE",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "18",
                "Route" => "SEDGEFIELD",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "23",
                "Route" => "ALBERTINIA",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "24",
                "Route" => "LADISMITH",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "25",
                "Route" => "STAFF",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "26",
                "Route" => "UNIONDALE",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "27",
                "Route" => "OUDTSHOORN2",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "28",
                "Route" => "OUDTSHOORN3",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "29",
                "Route" => "Langkloof District",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "30",
                "Route" => "HEIDELBERG",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "31",
                "Route" => "GREAT BRAK RIVER",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "33",
                "Route" => "KARATARA DISTRICT",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "34",
                "Route" => "Paarl",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "35",
                "Route" => "Nelspruit",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "36",
                "Route" => "REPS",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "37",
                "Route" => "OLD GEORGE ROAD",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "38",
                "Route" => "STILL BAY DISTRICT",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "40",
                "Route" => "THEMBALETHU",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "41",
                "Route" => "PACALTSDORP INDUSTRIAL",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "44",
                "Route" => "HARKERVILLE",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "45",
                "Route" => "SWELLENDAM",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "48",
                "Route" => "test1",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "49",
                "Route" => "test3",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "50",
                "Route" => "test4",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ]
        ];
        foreach ($response as &$item) {
            $item = (object) $item;
        }

        return $response;
    }

    public function apiCallListDeliveryDate()
    {
        $response = [
            (object) [
                "dteSessionDate" => "2022-07-15"
            ]
        ];

        return $response;
    }

    public function apiGetSalesOrderCustomers($data)
    {
        return $this->httpRequest('post', 'searchcustomers', $data);
    }

    public function apiGetSalesOrderProducts($data)
    {
        $response = $this->httpRequest('post', 'searchProducts', $data);
        if (!$response) {
            $response = [];
        } elseif ($response && isset($response['PastelCode'])) {
            $response = [$response];
        }
        //Pending From API: we need at the api side like if one record then also we need to merge with array

        return $response;
    }

    public function apiGetThings($data)
    {
        return $this->httpRequest('post', 'Post_GetThings', $data);
    }
}
