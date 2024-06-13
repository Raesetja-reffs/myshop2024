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
        return $this->httpRequest('post', 'Post_AlterBuyerContactsWhileOnOrder', $data);
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
        return $this->httpRequest('post', 'Post_GetCustomerDeliveryAddresses', $data);
    }

    public function apiAssignInvoiceNumber($data)
    {
        return '';
    }

    public function apiCheckifInvoiced($data)
    {
        return $this->httpRequest('post', 'Post_CheckInvoiced', $data);
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
        $productsHavingZeroCost = $this->httpRequest('post', 'Post_XmlProductHavingZeroCost', $data);
        $checkProductHavingZeroCost = $this->httpRequest('post', 'Post_HasProductHavingZeroCost', $data);

        return [
            'Result' => $checkProductHavingZeroCost[0]['Result'] ?? 'Nothing',
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

    public function apiGetextracomunsforItems()
    {
        return [
            [
                'Description_2' => '1'
            ]
        ];
    }

    public function apiCopyorder()
    {
        return [];
    }
}
