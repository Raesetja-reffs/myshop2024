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

    public function apiGeneralPriceChecking($data)
    {
        return [
            [
                "PriceList" => "Retail",
                "PriceListId" => "1",
                "PastelCode" => "BEV1280",
                "PastelDescription" => "STAYFREE N/WING SC.    9x4x10s",
                "Price" => "16.20",
                "Date" => "1980-01-01 00:00:00.000",
                "PriceInc" => "18.63",
                "StatusId" => "1"
            ]
        ];
        //return $this->httpRequest('post', '', $data);
    }

    public function apiGetProductStockOnHand($data)
    {
        return [
            [
                "AvgCost" => ".0000",
                "Code" => "WATER",
                "Cost" => ".0000",
                "Qty" => "0.0",
                "QtyInStock" => ".0000",
                "Remaining" => "0.0",
            ]
        ];
        //return $this->httpRequest('post', '', $data);
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
}
