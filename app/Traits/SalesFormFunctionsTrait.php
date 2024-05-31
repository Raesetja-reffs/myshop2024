<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait SalesFormFunctionsTrait
{
    use ApiTrait;

    public function apiInsertOrderHearder($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;
        $response = $this->httpRequest('post', 'InsertNewOrder', $data);

        return $response;
    }

    public function apiReturnProductPrice($data)
    {
        // $user = auth()->guard('central_api_user')->user();
        // $data['companyid'] = $user->company_id;
        // $data['UserID'] = $user->erp_user_id;
        //$response = $this->httpRequest('post', 'InsertNewOrder', $data);
        $response = [
            [
                "Price" => "3150.0",
                "ProductId" => "6591",
                "Tax" => "0.14999999999999999",
                "Prohibited" => "0",
                "AvailableToSell" => "32.200000000000003",
                "mustAuthLine" => "0",
                "LineDisc" => "0.0",
                "PriceType" => "CS",
                "intAssociated" => "0",
                "NettPrice" => "3150.0"
            ]
        ];

        return $response;
    }

    public function apiAssociatedItem($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;
        //$response = $this->httpRequest('post', 'InsertNewOrder', $data);
        $response = [];

        return $response;
    }

    public function apiGetCustomerRouteWithOtherRoutesByPriority($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;

        return $this->httpRequest('post', 'GetCustomerRoutes', $data);
    }

    public function apiCombinedSpecials()
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;
        $groupSpecials = $this->httpRequest('post', 'GetGroupSpecials', $data);
        $customerSpecials = $this->httpRequest('post', 'GetCustomerSpecials', $data);
        $pastInvoices = $this->httpRequest('post', 'GetPastCustomerInvoices', $data);

        $response = [
            "customerSpecials" => $customerSpecials,
            "GroupSpecials" => $groupSpecials,
            "pastInvoices" => $pastInvoices,
            "contacts" => [
                [
                    "BuyerContact" => null,
                    "BuyerTelephone" => "044 873 5015",
                    "CellPhone" => null
                ]
            ]
        ];

        return $response;
    }

    public function apiGetCustomerOderpattern($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;

        return $this->httpRequest('post', 'GetOrderPattern', $data);
    }

    public function apiGeneralPriceCheckAndLastCost($data)
    {
        $response = [
            "pricelists" => [
                [
                    "PriceList" => "Retail",
                    "PriceListId" => "1",
                    "PastelCode" => "AB082501",
                    "PastelDescription" => "LIQUIFR 250ML MANGO/ORANGE x24",
                    "Price" => "4258.35",
                    "Date" => "1980-01-01 00:00:00.000",
                    "PriceInc" => "4897.10",
                    "StatusId" => "1"
                ]
            ],
            "sellingPrice" => [
                [
                    "Price" => "3150.000",
                    "DeliveryDate" => "2019-02-20",
                    "Margin" => "8.840"
                ],
                [
                    "Price" => "3150.000",
                    "DeliveryDate" => "2019-02-12",
                    "Margin" => "8.840"
                ],
                [
                    "Price" => "3080.000",
                    "DeliveryDate" => "2018-02-12",
                    "Margin" => "6.770"
                ],
                [
                    "Price" => "3080.000",
                    "DeliveryDate" => "2018-01-22",
                    "Margin" => "6.770"
                ],
                [
                    "Price" => "3080.000",
                    "DeliveryDate" => "2018-09-21",
                    "Margin" => "6.770"
                ]
            ]
        ];

        return $response;
    }

    public function apiDeleteByHiddenToken()
    {
        return 'SUCCESS';
    }

    public function apiDeleteOrderLinedetails($data)
    {
        $response = [
            [
                'Result' => 'Success'
            ]
        ];

        return $response;
    }

    public function apiOrderheaderAndOrderLines($data)
    {
        $response = [
            'result' => 'SUCCESS',
            'Error' => 'SUCCESS',
            'Extras' => ''
        ];

        return $response;
    }

    public function apiOnCheckOrderHeaderDetails($data)
    {
        $response = [
            [
                "OrderId" => "388108",
                "OrderDetailId" => "1481393",
                "Qty" => "1.0",
                "ProductId" => "6591",
                "Price" => "3150.00",
                "Comment" => "",
                "LineDisc" => "0.0",
                "IncPrice" => "3622.50",
                "IncNettPrice" => "3622.5",
                "PastelCode" => "AB082501",
                "PastelDescription" => "LIQUIFR 250ML MANGO/ORANGE x24",
                "Cost" => "2854.5061",
                "QtyInStock" => "31.200000000000003",
                "DispatchQty" => "1.0",
                "TaxId" => "1",
                "Tax" => "15.0",
                "MESSAGESINV" => null,
                "OrderNo" => "",
                "AwaitingStock" => "0",
                "UnitSize" => "EA",
                "UnitCount" => "0.0",
                "ProductMargin" => "14.99",
                "ID" => "1",
                "Warehouse" => "001"
            ],
            [
                "OrderId" => "388108",
                "OrderDetailId" => "1481394",
                "Qty" => "1.0",
                "ProductId" => "6592",
                "Price" => "1785.00",
                "Comment" => "",
                "LineDisc" => "0.0",
                "IncPrice" => "2052.75",
                "IncNettPrice" => "2052.75",
                "PastelCode" => "AB083055",
                "PastelDescription" => "LIQUIFR 250ML MANGO/ORANGE  x6",
                "Cost" => "1469.1167",
                "QtyInStock" => "13.800000000000001",
                "DispatchQty" => "1.0",
                "TaxId" => "1",
                "Tax" => "15.0",
                "MESSAGESINV" => null,
                "OrderNo" => "",
                "AwaitingStock" => "0",
                "UnitSize" => "EA",
                "UnitCount" => "0.0",
                "ProductMargin" => "14.99",
                "ID" => "1",
                "Warehouse" => "001"
            ]
        ];

        return $response;
    }

    public function apiUpdateCContactsOnOrder($data)
    {
        return 1;
    }

    public function apiMarkitawaitingstock($data)
    {
        return '';
    }

    public function apiTreatAsQuote($data)
    {
        return '';
    }

    public function apiAdvancedOrderNo($data)
    {
        $response = [
            [
                'OrderNo' => '',
                'Brand' => 'Margot Swiss',
                'BrandId' => '1'
            ]
        ];

        return $response;
    }

    public function apiInsertNewAddress($data)
    {
        return true;
    }

    public function apiTempDeliverAddress($data)
    {
        return true;
    }

    public function apiChangeDeliveryAddressOnNoInvoiceNo($data)
    {
        $response = [
            [
                "CustomerPastelCode" => "000001",
                "StoreName" => "000001Customer",
                "DeliveryAddressID" => "70",
                "DAddress1" => "Del Address 1",
                "DAddress2" => "Del Address 2",
                "DAddress3" => "GEORGE",
                "DAddress4" => "6530",
                "DAddress5" => "",
                "SalesmanCode" => "115",
                "UserID" => "1",
                "Routeid" => "10"
            ]
        ];

        return $response;
    }

    public function apiAssignInvoiceNumber($data)
    {
        return '';
    }

    public function apiCheckifInvoiced($data)
    {
        return '';
    }

    public function apiWaitingForInvoiceNo($data)
    {
        return '';
    }

    public function apiIsClosedRoute($data)
    {
        $response = [
            'isClosed' => 0,
            'routeId' => 10,
            'routeOnOrder' => 10,
        ];

        return $response;
    }

    public function apiCheckZeroCostOnOrder($data)
    {
        $response = [
            'result' => 'Nothing'
        ];

        return $response;
    }

    public function apiSelectCustomerMultiAddressconfirm($data)
    {
        $response = [
            "addresses" => [
                [
                    "CustomerPastelCode" => "000001",
                    "StoreName" => "000001Customer",
                    "DeliveryAddressID" => "0",
                    "DAddress1" => "Del Address 1",
                    "DAddress2" => "Del Address 2",
                    "DAddress3" => "GEORGE",
                    "DAddress4" => "6530",
                    "DAddress5" => null,
                    "SalesmanCode" => "115",
                    "UserID" => "1",
                    "Routeid" => "10",
                    "CustomerOnHold" => "0"
                ]
            ],
            "selectedaddress" => [
                [
                    "Priorities" => "0",
                    "CustomerPastelCode" => "000001",
                    "StoreName" => "000001Customer",
                    "DeliveryAddressID" => "0",
                    "DAddress1" => "Del Address 1",
                    "DAddress2" => "Del Address 2",
                    "DAddress3" => "GEORGE",
                    "DAddress4" => "6530",
                    "DAddress5" => "",
                    "SalesmanCode" => null,
                    "UserID" => "1",
                    "Routeid" => "10",
                    "CustomerOnHold" => "0",
                    "Route" => "GEORGE"
                ]
            ],
            "routes" => [
                [
                    "Routeid" => "23",
                    "Route" => "ALBERTINIA",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "A1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "2",
                    "Route" => "BEAUFORT WEST",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "B1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "5",
                    "Route" => "COLLECTIONS",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "COL",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "6",
                    "Route" => "COURIER",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "COU",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "10",
                    "Route" => "GEORGE",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "G4",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "31",
                    "Route" => "GREAT BRAK RIVER",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "44",
                    "Route" => "HARKERVILLE",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "30",
                    "Route" => "HEIDELBERG",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "13",
                    "Route" => "JEFFREYS BAY",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "J1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "33",
                    "Route" => "KARATARA DISTRICT",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "14",
                    "Route" => "KNYNSA",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "K1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "24",
                    "Route" => "LADISMITH",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "L1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "29",
                    "Route" => "Langkloof District",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "3",
                    "Route" => "MOSSELBAY 1",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "CBS1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "4",
                    "Route" => "MOSSELBAY 2",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "CBS2",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "35",
                    "Route" => "Nelspruit",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "1",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "1",
                    "Route" => "No Route",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "37",
                    "Route" => "OLD GEORGE ROAD",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "15",
                    "Route" => "OUDTSHOORN",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "O1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "27",
                    "Route" => "OUDTSHOORN2",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "28",
                    "Route" => "OUDTSHOORN3",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "34",
                    "Route" => "Paarl",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "1",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "41",
                    "Route" => "PACALTSDORP INDUSTRIAL",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "16",
                    "Route" => "PLETTENBERG BAY",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "P1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "36",
                    "Route" => "REPS",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "17",
                    "Route" => "RIVERSDALE",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "R1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "18",
                    "Route" => "SEDGEFIELD",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "1",
                    "LocationId" => "1",
                    "Rmessage" => "S1",
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "25",
                    "Route" => "STAFF",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "38",
                    "Route" => "STILL BAY DISTRICT",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "45",
                    "Route" => "SWELLENDAM",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "48",
                    "Route" => "test1",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "49",
                    "Route" => "test3",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "50",
                    "Route" => "test4",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "40",
                    "Route" => "THEMBALETHU",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ],
                [
                    "Routeid" => "26",
                    "Route" => "UNIONDALE",
                    "NotInUse" => "0",
                    "InActive" => "0",
                    "NewRec" => "0",
                    "LocationId" => "1",
                    "Rmessage" => null,
                    "MinOrderLevel" => null,
                    "DoNotInvoice" => "0",
                    "DepotCode" => null
                ]
            ]
        ];

        return $response;
    }
}
