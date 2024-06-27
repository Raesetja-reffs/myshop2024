<?php

namespace App\Traits;

use App\Traits\ApiTrait;
use App\Traits\UtilityTrait;

trait SalesFormFunctionsTrait
{
    use ApiTrait;
    use UtilityTrait;

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
        return $this->convertToCollectionObject($this->httpRequest('post', 'Post_OnCountOnOrder', $data));
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
        return $this->httpRequest('post', 'Post_OnOrder', $data);
    }

    public function apiProductsOnInvoiced($data)
    {
        return $this->httpRequest('post', 'Post_OnInvoiced', $data);
    }
    
    public function apiSplitordersmake($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->convertToCollectionObject($this->httpRequest('post', 'Post_XMLSplitOrder', $data));
    }
}
