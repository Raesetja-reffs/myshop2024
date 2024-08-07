<?php

namespace App\Traits;

use App\Traits\UtilityTrait;

trait DimsCommonTrait
{
    use UtilityTrait;

    public function apiInvoiceLookup($data)
    {
        $queries = $this->httpRequest('post', 'Post_InvoiceLookUp', $data);
        $queries = $this->convertToCollectionObject($queries);

        return $queries;
    }

    public function apiChangerouteonorder($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_ChangeRouteOnOrder', $data);
    }

    public function apiChangesalesman($data)
    {
        $data = $this->setUserNameInApiData($data);

        return $this->httpRequest('post', 'Post_ChangeSalesman', $data);
    }

    public function apiVerifyAuth($data)
    {
        return $this->httpRequest('post', 'Post_GeneralUsernamePasswordAuth', $data);
    }

    public function apiClearorderlocksperorder($data)
    {
        return $this->httpRequest('post', 'Post_DeleteOrderLocksPerUser', $data);
    }

    public function apiInvoicedoc($data)
    {
        return $this->httpRequest('post', 'Post_PrintInvoice', $data);
    }

    public function apiCheckifhasmultiaddress($data)
    {
        return $this->httpRequest('post', 'Post_HasMultiDeliveryAddress', $data);
    }

    public function apiAuthBulkZeroCost($data)
    {
        return $this->httpRequest('post', 'Post_AuthBulkZeroCost', $data);
    }

    public function apiVerifyAuthOnAdmin($data)
    {
        return $this->httpRequest('post', 'Post_AuthMinimumGP', $data);
    }

    public function apiGetDataFromManagementConsole($data)
    {
        return $this->httpRequest('post', 'Post_Retrivemanagementconsoledata', $data);
    }

    public function apiUpdateallOrderlinestocostauth($data)
    {
        return $this->httpRequest('post', 'Post_UpdateblnAuthCost', $data);
    }

    public function apiDeleteuserOrderLocks()
    {
        return $this->httpRequest('post', 'Post_DeleteOrderLocksPerUserAndDept');
    }
    public function apiGetDeletedOrdersJson($data)
    {
        return $this->httpRequest('post', 'Post_GetDeletedOrdersJson',$data);
    }

    public function apiVerifyAuthMario($data)
    {
        return $this->httpRequest('post', 'Post_NoStockOnALine', $data);
    }

    public function apiCustomerflexgrid()
    {
        $customers = $this->httpRequest('post', 'Post_CustomersGridCustomers');
        $routes = $this->httpRequest('post', 'Post_CustomersGridRoutes');
        $groups = $this->httpRequest('post', 'Post_CustomersGridGroups');
        $salesmen = $this->httpRequest('post', 'Post_CustomersGridSalesmen');
        $users = $this->httpRequest('post', 'Post_CustomersGridUsers');

        return [
            'customers' => $customers,
            'routes' => $routes,
            'groups' => $groups,
            'salesmen' => $salesmen,
            'users' => $users,
        ];
    }

    public function apiUpdateCustomerGrid($data){
        return $this->httpRequest('post', 'Post_UpdateCustomerGrid', $data);
    }

    public function apiCustomerSpecialsCustomers(){
        return $this->httpRequest('post', 'Post_CustomerSpecialsCustomers');
    }

    public function apiCustomerSpecialsProducts(){
        return $this->httpRequest('post', 'Post_CustomerSpecialsProducts');
    }

    public function apiCustomerSpecialsDeals(){
        return $this->httpRequest('post', 'Post_CustomerSpecialsDeals');
    }

    public function apiGetOverallCustomerSpecials($data){
        return $this->httpRequest('post', 'Post_OverallCustomerSpecials', $data);
    }

    public function apiXmlCreateCustomerSpecials($data){
        return $this->convertToCollectionObject($this->httpRequest('post', 'Post_XmlCreateCustomerSpecials', $data));
    }

    public function apiRemoveCustomerSpecial($data){
        return $this->httpRequest('post', 'Post_RemoveCustomerSpecial', $data);
    }

    public function apiAdminAuthorize($data){
        return $this->httpRequest('post', 'Post_AdminAuthorize', $data);
    }

    public function apiGetOverallGroupSpecials($data){
        return $this->httpRequest('post', 'Post_OverallGroupSpecials', $data);
    }

    public function apiXmlCreateGroupSpecials($data){
        return $this->convertToCollectionObject($this->httpRequest('post', 'Post_XmlCreateGroupSpecials', $data));
    }

    public function apiRemoveGroupSpecial($data){
        return $this->httpRequest('post', 'Post_RemoveGroupSpecial', $data);
    }

    public function apiGroupSpecialsGroups(){
        return $this->httpRequest('post', 'Post_GroupSpecialsGroups');
    }

    public function apiGroupSpecialsDeals(){
        return $this->httpRequest('post', 'Post_GroupSpecialsDeals');
    }
    
    public function apiManagementConsoleData($data){
        return $this->httpRequest('post', 'Post_ManagementConsoleData',$data);
    }

}
