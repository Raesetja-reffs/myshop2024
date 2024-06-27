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
        return $this->httpRequest('post', 'Post_CustomerPriceLookUp', $data);
    }

    public function apiAssociatedItem($data)
    {
        return $this->httpRequest('post', 'Post_CustomerPriceLookUpAssociatedItems', $data);
    }

    public function apiGetCustomerRouteWithOtherRoutesByPriority($data)
    {
        return $this->httpRequest('post', 'GetCustomerRoutes', $data);
    }

    public function apiCombinedSpecials($data)
    {
        $groupSpecials = $this->httpRequest('post', 'GetGroupSpecials', $data, true);
        $customerSpecials = $this->httpRequest('post', 'GetCustomerSpecials', $data, true);
        $pastInvoices = $this->httpRequest('post', 'GetPastCustomerInvoices', $data, true);
        $getBuyerContacts = $this->httpRequest('post', 'Post_GetBuyerContacts', $data, true);

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
        $pricelists = $this->httpRequest('post', 'GeneralPriceCheck', $data, true);

        $user = auth()->guard('central_api_user')->user();
        $data['LocationId'] = $user->location_id;
        $sellingPrice = $this->httpRequest('post', 'GetLastSellingPrice', $data);

        return [
            'pricelists' => $pricelists,
            'sellingPrice' => $sellingPrice,
        ];
    }

    public function apiDeleteByHiddenToken($data)
    {
        return $this->httpRequest('post', 'Post_DeleteHiddenToken', $data);
    }

    public function apiDeleteOrderLinedetails($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_DeleteOrderLinedetails', $data, true);
    }

    public function apiOrderheaderAndOrderLines($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_XmlOrderHeadersAndLines', $data);
    }

    public function apiOnCheckOrderHeaderDetails($data)
    {
        return $this->httpRequest('post', 'GetOrderIdLines', $data, true);
    }

    public function apiUpdateCContactsOnOrder($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_AlterBuyerContactsWhileOnOrder', $data);
    }

    public function apiMarkitawaitingstock($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'AwaitingStock', $data);
    }

    public function apiTreatAsQuote($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_treatasquote', $data);
    }

    public function apiAdvancedOrderNo($data)
    {
        return $this->httpRequest('post', 'GetAdvancedOrderNo', $data);
    }

    public function apiInsertNewAddress($data)
    {
        return $this->httpRequest('post', 'Post_AddNewAddress', $data);
    }

    public function apiTempDeliverAddress($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['salesmanID'] = $user->erp_user_id;

        return $this->httpRequest('post', 'InsertTempDeliveryAddress', $data);
    }

    public function apiChangeDeliveryAddressOnNoInvoiceNo($data)
    {
        return $this->httpRequest('post', 'Post_GetCustomerDeliveryAddresses', $data);
    }

    public function apiAssignInvoiceNumber($data)
    {
        return $this->httpRequest('post', 'Post_AssignInvoiceNumber', $data);
    }

    public function apiCheckifInvoiced($data)
    {
        return $this->httpRequest('post', 'Post_CheckInvoiced', $data);
    }

    public function apiWaitingForInvoiceNo($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_WaitingInvoiceNo', $data);
    }

    public function apiIsClosedRoute($data)
    {
        return $this->httpRequest('post', 'isRouteClosed', $data);
    }

    public function apiCheckZeroCostOnOrder($data)
    {
        $productsHavingZeroCost = $this->httpRequest('post', 'Post_XmlProductHavingZeroCost', $data);
        $checkProductHavingZeroCost = $this->httpRequest('post', 'Post_HasProductHavingZeroCost', $data);

        return [
            'result' => $checkProductHavingZeroCost[0]['Result'] ?? 'Nothing',
            'data' => $productsHavingZeroCost
        ];
    }

    public function apiSelectCustomerMultiAddressconfirm($data)
    {
        $addresses = $this->httpRequest('post', 'Post_GetCustomerDeliveryAddresses', $data);
        $selectedaddress = $this->httpRequest('post', 'Post_GetSelectedAddressForMultiDeliveriesByOrderID', $data);
        $routes = $this->httpRequest('post', 'Post_GetRoutes', $data);

        return [
            "addresses" => $addresses,
            "selectedaddress" => $selectedaddress,
            "routes" => $routes
        ];
    }

    public function apiOnCheckOrderHeader($data)
    {
        $response = $this->httpRequest('post', 'Post_ReturnInvoiceOrderIdData', $data);
        if (isset($response['data'][0]['OrderId'])) {
            $response['data'][0]['orderID'] = $response['data'][0]['OrderId'];
        }

        return [
            'data' => $response['data'],
            'returns' => $response['Returns'][0]['returns'],
        ];
    }

    public function apiGetextracomunsforItems($data)
    {
        return $this->httpRequest('post', 'Post_RetrieveExtraProductInfo', $data);
    }

    public function apiUpdateDiscount($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_UpdateDiscPercent', $data);
    }

    public function apiSelectCustomerMultiAddress($data)
    {
        return $this->httpRequest('post', 'Post_GetCustomerDeliveryAddresses', $data);
    }

    public function apiGetOrderListing($data)
    {
        return $this->httpRequest('post', 'Post_RetrieveOrderListing', $data);
    }

    public function apiInsertCopyorder($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_CopyOrder', $data);
    }

    public function apiCheckIfOrderExists($data)
    {
        return $this->httpRequest('post', 'Post_CheckIfOrderExists', $data);
    }

    public function apiSplitorders($data)
    {
        return $this->httpRequest('post', 'Post_RetrieveGetProductForBackOrder', $data);
    }

    public function apiGeneralPriceChecking($data)
    {
        return $this->httpRequest('post', 'Post_GeneralPriceCheck', $data);
    }

    public function apiGetProductStockOnHand($data)
    {
        return $this->httpRequest('post', 'Post_GetProductStockOnHand', $data);
    }

    public function apiCountOnSalesOrder($data)
    {
        return [
            (object) [
                'Qty' => "0.0"
            ]
        ];
        //return $this->httpRequest('post', '', $data);
    }

    public function apiProductPriceLookUp($data)
    {
        $response = $this->httpRequest('post', 'Post_ProductPriceLookUp', $data);

        return [
            'priceList' => $this->convertToMultipleArray($response['Result']['Table1']),
            'productPriceForCust' => $this->convertToMultipleArray($response['Result']['Table']),
            'stock' => $this->convertToMultipleArray($response['Result']['Table2']),
            'currentPrices' => $this->convertToMultipleArray($response['Result']['Table3']),
        ];
    }

    public function apiGetCallList($data)
    {
        return [
            [
                "CustomerId" => "3771",
                "CustomerPastelCode" => "000622",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "000622Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "LOUISE BALANCO",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 878 0859",
                "LocationID" => null,
                "BalanceDue" => "14909.0200",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "3772",
                "CustomerPastelCode" => "000623",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "000623Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "JACKIE VAN ZYL/MARY WHITELAW",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 874 0585",
                "LocationID" => null,
                "BalanceDue" => "1786.8100",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "3188",
                "CustomerPastelCode" => "002505",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "002505Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "DUNCAN BROWN",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 870 0911",
                "LocationID" => null,
                "BalanceDue" => ".0000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "3190",
                "CustomerPastelCode" => "002507",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "002507Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "WIKUS DE SWART/ EMMERENCIA",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 620 2300",
                "LocationID" => null,
                "BalanceDue" => ".0000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "1425",
                "CustomerPastelCode" => "COD032",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD032Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "CALIE BREYTENBACH",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 878 0299",
                "LocationID" => null,
                "BalanceDue" => ".0000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "2031",
                "CustomerPastelCode" => "COD097",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD097Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "Nathalie",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 874 2262",
                "LocationID" => null,
                "BalanceDue" => ".0000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "4339",
                "CustomerPastelCode" => "COD108",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD108Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "ALFEA",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 873 2995",
                "LocationID" => null,
                "BalanceDue" => ".0000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "1487",
                "CustomerPastelCode" => "COD1494",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD1494Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "KHUTHALA  NYOBOLE",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 880 1019",
                "LocationID" => null,
                "BalanceDue" => "-669.8700",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "3345",
                "CustomerPastelCode" => "COD1837",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD1837Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "ALLEN VAN COLLER",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 875 8820",
                "LocationID" => null,
                "BalanceDue" => "1978.0000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "1578",
                "CustomerPastelCode" => "COD2051",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD2051Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "ADRIAN LOUW",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "083 324 3903",
                "LocationID" => null,
                "BalanceDue" => ".0000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "1579",
                "CustomerPastelCode" => "COD2052",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD2052Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "PETER H. FILLIES",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 878 1276",
                "LocationID" => null,
                "BalanceDue" => "1277.8800",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "1644",
                "CustomerPastelCode" => "COD3005",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD3005Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "PAUL DAVISON",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 802 7300",
                "LocationID" => null,
                "BalanceDue" => ".0000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "4645",
                "CustomerPastelCode" => "COD5324",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD5324Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "HEINRICH STRYDOM",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 874 5895",
                "LocationID" => null,
                "BalanceDue" => "-.5000",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],
            [
                "CustomerId" => "4646",
                "CustomerPastelCode" => "COD5325",
                "GroupId" => "6",
                "UserID" => "1",
                "StoreName" => "COD5325Customer",
                "AreaId" => null,
                "Routeid" => "GEORGE",
                "Terms" => "0",
                "StatusId" => "1",
                "ContactTel" => null,
                "ContactFax" => null,
                "ContactPerson" => "VICKY BOTHA",
                "Email" => "paul@lsystems.co.za",
                "CellPhone" => null,
                "Account" => "0",
                "OwnerID" => "1",
                "BuyerContact" => null,
                "BuyerTelephone" => "044 801 7411",
                "LocationID" => null,
                "BalanceDue" => "-.0600",
                "UserName" => "Admin",
                "Discount" => "0.0",
                "custRouteId" => "10"
            ],

        ];
    }

    public function apiInsertCallID($data)
    {
        return [];
    }

    public function apiProductsOnOrder($data)
    {
        return [
            [
                "OrderId" => "361323",
                "OrderDetailId" => "1390916",
                "PastelCode" => "16333",
                "PastelDescription" => "HF FO-MO-PAK TRAYS N04    125s",
                "Qty" => "200.0",
                "InStock" => "-8.0",
                "CustomerPastelCode" => "COD2344",
                "StoreName" => "COD2344Customer",
                "Comment" => "",
                "NettPrice" => "128.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-02-26",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "361323",
                "OrderDetailId" => "1390923",
                "PastelCode" => "MSE005",
                "PastelDescription" => "EEZEE NOODLES CHICKEN   50x65g",
                "Qty" => "50.0",
                "InStock" => "-38.0",
                "CustomerPastelCode" => "COD2344",
                "StoreName" => "COD2344Customer",
                "Comment" => "",
                "NettPrice" => "43.549999999999997",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-02-26",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399462",
                "PastelCode" => "MUL1025",
                "PastelDescription" => "BEACON MALLOW EGG WHIPY  1x24s",
                "Qty" => "1.0",
                "InStock" => "-8.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "183.19999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399466",
                "PastelCode" => "DUX-DWA25",
                "PastelDescription" => "JOHNSON BABY PWD LAVEN  1x200g",
                "Qty" => "1.0",
                "InStock" => "20.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "328.94999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399473",
                "PastelCode" => "1139896",
                "PastelDescription" => "RAJAH ALL IN ONE        10x50g",
                "Qty" => "1.0",
                "InStock" => "-37.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "7.5",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399482",
                "PastelCode" => "TBCT05",
                "PastelDescription" => "W.W.E ASSORTED RINGS    50x16g",
                "Qty" => "1.0",
                "InStock" => "13.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "45.299999999999997",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399483",
                "PastelCode" => "AS05",
                "PastelDescription" => "SELATI WHITE SUGAR     4x2.5kg",
                "Qty" => "1.0",
                "InStock" => "1.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "57.950000000000003",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399498",
                "PastelCode" => "WC01",
                "PastelDescription" => "FUTURELIFE CRUNCH CHOC 20x540g",
                "Qty" => "1.0",
                "InStock" => "42.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "9.8499999999999996",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399500",
                "PastelCode" => "WIN05",
                "PastelDescription" => "KNORROX S.M BAG SAVOUR4x5x400g",
                "Qty" => "1.0",
                "InStock" => "201.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "50.950000000000003",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399501",
                "PastelCode" => "WC25",
                "PastelDescription" => "PURITY 4 AP/P/GR YOG 4x6x250ml",
                "Qty" => "1.0",
                "InStock" => "25.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "118.95",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "362574",
                "OrderDetailId" => "1399510",
                "PastelCode" => "AP39",
                "PastelDescription" => "PENGO MEGA ORANGE/STRW 24x50pc",
                "Qty" => "1.0",
                "InStock" => "2.0",
                "CustomerPastelCode" => "COD2325",
                "StoreName" => "COD2325Customer",
                "Comment" => "",
                "NettPrice" => "174.40000000000001",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-03",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414632",
                "PastelCode" => "50677",
                "PastelDescription" => "SURF W/P FLEXI          6x600g",
                "Qty" => "1.0",
                "InStock" => "-4117.7450980392159",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "139.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414634",
                "PastelCode" => "012",
                "PastelDescription" => "SPICE BARBECUE         8x5x35g",
                "Qty" => "1.0",
                "InStock" => "69.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "174.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414636",
                "PastelCode" => "16015",
                "PastelDescription" => "COKE CAN 300 LEMON TWIST   x24",
                "Qty" => "1.0",
                "InStock" => "26.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "43.899999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366435",
                "OrderDetailId" => "1414707",
                "PastelCode" => "GRLNTM",
                "PastelDescription" => "TROTTERS JELLY-PEACH   4x6x40g",
                "Qty" => "4.0",
                "InStock" => "35.0",
                "CustomerPastelCode" => "000108",
                "StoreName" => "000108Customer",
                "Comment" => "",
                "NettPrice" => "100.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-20",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414903",
                "PastelCode" => "400127",
                "PastelDescription" => "AIRWICK COTTON BREEZE2x6x280ml",
                "Qty" => "1.0",
                "InStock" => "0.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "160.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414909",
                "PastelCode" => "400188",
                "PastelDescription" => "COLGATE SHAMPOO EGG  3x6x350ml",
                "Qty" => "1.0",
                "InStock" => "7.0008280033120132",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "11.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414914",
                "PastelCode" => "400197",
                "PastelDescription" => "PLEDGE LIQ P/POURRI  2x6x750ml",
                "Qty" => "1.0",
                "InStock" => "-2.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "290.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414925",
                "PastelCode" => "59",
                "PastelDescription" => "VITAMIN WATER MIXED   24x500ml",
                "Qty" => "1.0",
                "InStock" => "10.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "33.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414929",
                "PastelCode" => "41725A X",
                "PastelDescription" => "PECKS ANCHOVETTE        6x125g",
                "Qty" => "1.0",
                "InStock" => "-18.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "5.7999999999999998",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414932",
                "PastelCode" => "SS/CS",
                "PastelDescription" => "COKE BUDDY 500 ORANGE ZERO x24",
                "Qty" => "1.0",
                "InStock" => "-57.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "8.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414934",
                "PastelCode" => "153",
                "PastelDescription" => "COKE CAN 300 SPRITE LS      x6",
                "Qty" => "1.0",
                "InStock" => "-22.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "14.0",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ],
            [
                "OrderId" => "366318",
                "OrderDetailId" => "1414937",
                "PastelCode" => "265",
                "PastelDescription" => "CAPPY JUICE ORANGE     6x330ml",
                "Qty" => "1.0",
                "InStock" => "-22.0",
                "CustomerPastelCode" => "COD1742",
                "StoreName" => "COD1742Customer",
                "Comment" => "",
                "NettPrice" => "16.699999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2020-06-23",
                "OrderDate" => "2020-03-19",
                "GPperc" => "1",
                "AwaitingStock" => "0"
            ]
        ];
    }

    public function apiProductsOnInvoiced($data)
    {
        return [
            [
                "OrderId" => "388099",
                "PastelCode" => "A.1 SPRAYE.BLYS",
                "PastelDescription" => "VALPRE STILL           6x500ml",
                "Qty" => "1.0",
                "CustomerPastelCode" => "AFW002",
                "StoreName" => "AFW002Customer",
                "Comment" => "",
                "NettPrice" => "17.0",
                "Backorder" => "0",
                "DeliveryDate" => "2024-01-12",
                "OrderDate" => "2024-01-12",
                "locationName" => ""
            ],
            [
                "OrderId" => "388099",
                "PastelCode" => "ADV001",
                "PastelDescription" => "LIQUIFR CAN 340/330 ORANGE x24",
                "Qty" => "1.0",
                "CustomerPastelCode" => "AFW002",
                "StoreName" => "AFW002Customer",
                "Comment" => "",
                "NettPrice" => "0.0",
                "Backorder" => "0",
                "DeliveryDate" => "2024-01-12",
                "OrderDate" => "2024-01-12",
                "locationName" => ""
            ],
            [
                "OrderId" => "388099",
                "PastelCode" => "ALASKA-P-L",
                "PastelDescription" => "JUST J.CAN PASS/PEACH4x6x330ml",
                "Qty" => "1.0",
                "CustomerPastelCode" => "AFW002",
                "StoreName" => "AFW002Customer",
                "Comment" => "",
                "NettPrice" => "240.34999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2024-01-12",
                "OrderDate" => "2024-01-12",
                "locationName" => ""
            ],
            [
                "OrderId" => "384904",
                "PastelCode" => "REF1B",
                "PastelDescription" => "COO-EE CREME SODA     12x300ml",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000103",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "15.9",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384904",
                "PastelCode" => "006521-3",
                "PastelDescription" => "PAKCO VEG ATCHAR MILD   6x385g",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000103",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "15.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384904",
                "PastelCode" => "500066",
                "PastelDescription" => "STUYVESANT EVOLVE GOLD  10x20s",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000103",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "171.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384904",
                "PastelCode" => "12211",
                "PastelDescription" => "TORO'S SNAKE TR ASST FR 1x100g",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000103",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "157.40000000000001",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384905",
                "PastelCode" => "DUX-APC",
                "PastelDescription" => "ARIEL WASHING PWD P/BAG 6x250g",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000123",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "14.949999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384905",
                "PastelCode" => "FG/S-73-BK",
                "PastelDescription" => "AQUELLE 500ml APPLE         x6",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000123",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "265.19999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384905",
                "PastelCode" => "PLP21",
                "PastelDescription" => "ALWAYS MAXI SOFT NORMAL  4x10s",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000123",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "72.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384905",
                "PastelCode" => "CAS049",
                "PastelDescription" => "BEACON MALLOW EGG W/CH  24x24s",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000123",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "3730.6999999999998",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384905",
                "PastelCode" => "DWXRT40",
                "PastelDescription" => "BEACON FIZZER F/PK C/SODA1x24s",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000123",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "165.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384905",
                "PastelCode" => "CB4Y-007",
                "PastelDescription" => "Beacon Fizz Dub  Lem 20x100s",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000123",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "215.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384905",
                "PastelCode" => "500181",
                "PastelDescription" => "KOTEX MAXI WHITE NORM/W 16x10s",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000123",
                "StoreName" => "410 Meade Street",
                "Comment" => "",
                "NettPrice" => "250.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-22",
                "OrderDate" => "2023-08-22",
                "locationName" => ""
            ],
            [
                "OrderId" => "384902",
                "PastelCode" => "A.1 SPRAYB",
                "PastelDescription" => "BIOPLUS BOOST SH STR   48x10ml",
                "Qty" => "4.0",
                "CustomerPastelCode" => "000125",
                "StoreName" => "KwikSpar George",
                "Comment" => "",
                "NettPrice" => "14.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-17",
                "OrderDate" => "2023-08-17",
                "locationName" => ""
            ],
            [
                "OrderId" => "384903",
                "PastelCode" => "A.1 GLADE 04",
                "PastelDescription" => "LAY'S CARRIBEAN ONION   24x36g",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000125",
                "StoreName" => "KwikSpar George",
                "Comment" => "",
                "NettPrice" => "20.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-17",
                "OrderDate" => "2023-08-17",
                "locationName" => ""
            ],
            [
                "OrderId" => "384903",
                "PastelCode" => "A.1 GLADE 18",
                "PastelDescription" => "SALDANHA TOM BUFF      12x215g",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000125",
                "StoreName" => "KwikSpar George",
                "Comment" => "",
                "NettPrice" => "95.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-08-17",
                "OrderDate" => "2023-08-17",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-40-2",
                "PastelDescription" => "BAKERS TENNIS LEMON     3x200g",
                "Qty" => "5.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "125.3",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ],
            [
                "OrderId" => "377524",
                "PastelCode" => "POLY28",
                "PastelDescription" => "COKE 1L COKE ZERO       12x1lt",
                "Qty" => "3.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "415.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-09",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-41-2",
                "PastelDescription" => "BONAQUA STRAWBERRY    24x500ml",
                "Qty" => "15.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "125.5",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-53-1",
                "PastelDescription" => "H2O WATER SACHET      50x100ml",
                "Qty" => "4.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "289.0",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-56-2",
                "PastelDescription" => "SUNLIGHT B/S LIV LEM   12x100g",
                "Qty" => "2.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "122.65000000000001",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-60-BK-1",
                "PastelDescription" => "SUNLIGHT B/S JU ORAN   12x100g",
                "Qty" => "5.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "244.25",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-69-BK3",
                "PastelDescription" => "KLEENEX E/DAY 2PLY WHT   2x90s",
                "Qty" => "3.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "244.25",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-70",
                "PastelDescription" => "KLEENEX 3PLY WHITE      24x90s",
                "Qty" => "1.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "197.34999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-70-BK",
                "PastelDescription" => "KLEENEX 3PLY EXP CUBE   24x56s",
                "Qty" => "5.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "197.34999999999999",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ],
            [
                "OrderId" => "377099",
                "PastelCode" => "FG/S-71M-BK",
                "PastelDescription" => "KLNEX COMP SOFT PK 2PL   1x80s",
                "Qty" => "8.0",
                "CustomerPastelCode" => "000297",
                "StoreName" => "000297Customer",
                "Comment" => "",
                "NettPrice" => "283.25",
                "Backorder" => "0",
                "DeliveryDate" => "2023-03-14",
                "OrderDate" => "2020-06-08",
                "locationName" => ""
            ]
        ];
    }
}
