<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait SalesFormFunctionsTrait
{
    use ApiTrait;

    public function apiInsertOrderHearder($data)
    {
        return $this->httpRequest('post', 'InsertNewOrder', $data);
    }

    public function apiReturnProductPrice($data)
    {
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
        //$response = $this->httpRequest('post', '', $data);
        $response = [];

        return $response;
    }

    public function apiGetCustomerRouteWithOtherRoutesByPriority($data)
    {
        return $this->httpRequest('post', 'GetCustomerRoutes', $data);
    }

    public function apiCombinedSpecials($data)
    {
        $groupSpecials = $this->httpRequest('post', 'GetGroupSpecials', $data);
        $customerSpecials = $this->httpRequest('post', 'GetCustomerSpecials', $data);
        $pastInvoices = $this->httpRequest('post', 'GetPastCustomerInvoices', $data);
        $getBuyerContacts = $this->httpRequest('post', 'Post_GetBuyerContacts', $data);

        return [
            "customerSpecials" => $customerSpecials,
            "GroupSpecials" => $groupSpecials,
            "pastInvoices" => $pastInvoices,
            "contacts" => $getBuyerContacts
        ];
    }

    public function apiGetCustomerOderpattern($data)
    {
        return $this->httpRequest('post', 'GetOrderPattern', $data);
    }

    public function apiGeneralPriceCheckAndLastCost($data)
    {
        $pricelists = $this->httpRequest('post', 'GeneralPriceCheck', $data);
        if (!$pricelists) {
            $pricelists = [];
        } elseif ($pricelists && isset($pricelists['PriceList'])) {
            $pricelists = [$pricelists];
        }

        $user = auth()->guard('central_api_user')->user();
        $data['LocationId'] = $user->location_id;
        $sellingPrice = $this->httpRequest('post', 'GetLastSellingPrice', $data);
        if (!$sellingPrice) {
            $sellingPrice = [];
        }
        //Pending From API: we need at the api side like if one record then also we need to merge with array

        return [
            'pricelists' => $pricelists,
            'sellingPrice' => $sellingPrice,
        ];
    }

    public function apiDeleteByHiddenToken($data)
    {
        return $this->httpRequest('post', 'DeleteHiddenToken', $data);
    }

    public function apiDeleteOrderLinedetails($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'DeleteOrderLinedetails', $data);
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
        return $this->httpRequest('post', 'GetOrderIdLines', $data);
    }

    public function apiUpdateCContactsOnOrder($data)
    {
        return 1;
    }

    public function apiMarkitawaitingstock($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['Username'] = $user->erp_apiusername;

        return $this->httpRequest('post', 'AwaitingStock', $data);
    }

    public function apiTreatAsQuote($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['Username'] = $user->erp_apiusername;

        return $this->httpRequest('post', 'treatasquote', $data);
    }

    public function apiAdvancedOrderNo($data)
    {
        return $this->httpRequest('post', 'GetAdvancedOrderNo', $data);
    }

    public function apiInsertNewAddress($data)
    {
        return true;
    }

    public function apiTempDeliverAddress($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['salesmanID'] = $user->erp_user_id;

        return $this->httpRequest('post', 'InsertTempDeliveryAddress', $data);
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
        return $this->httpRequest('post', 'isRouteClosed', $data);
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

    public function apiOnCheckOrderHeader()
    {
        $response = [
            "data" => [
                [
                    "OrderId" => "366724",
                    "CustomerId" => "958",
                    "OrderDate" => "2020-03-23",
                    "RouteId" => "2",
                    "Route" => "BEAUFORT WEST",
                    "DeliveryDate" => "2020-03-26",
                    "LateOrder" => "2",
                    "OrderNo" => "Mariena",
                    "Invoiced" => "1",
                    "InvoiceNo" => "CAN366724",
                    "MESSAGESINV" => "0",
                    "Disc" => "0.0",
                    "DeliveryAddressID" => "0",
                    "DeliveryAddress1" => "Del Address 1",
                    "DeliveryAddress2" => "Del Address 2",
                    "DeliveryAddress3" => "BEAUFORT WES",
                    "DeliveryAddress4" => "6970",
                    "DeliveryAddress5" => null,
                    "CustomerPastelCode" => "000017",
                    "StoreName" => "000017Customer",
                    "CreditLimit" => "45000.0000",
                    "BalanceDue" => ".0000",
                    "OrderType" => "1stDelivery",
                    "Discount" => "0.0",
                    "TreatAsQuotation" => "0"
                ]
            ],
            "returns" => "inserted"
        ];

        return $response;
    }
}
