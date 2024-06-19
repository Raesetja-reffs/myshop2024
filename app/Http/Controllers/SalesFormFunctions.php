<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ConsoleManagement;
use App\Http\Controllers\DimsCommon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;
use View;
use App;
use PDF;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AuthenticateUsersAndCentralUser;
use App\Traits\SalesFormFunctionsTrait;

class SalesFormFunctions extends Controller
{
    use SalesFormFunctionsTrait;

    public function __construct()
    {
        $this->middleware(AuthenticateUsersAndCentralUser::class);
    }
    //returnProductPrice
    public function CustomerCode(Request $request)
    {
        $term = $request->get('term','');;

        $results = array();//vwtblCustomers
        $queries =DB::connection('sqlsrv3')->table("tblCustomers")
            ->where('CustomerPastelCode', 'LIKE', '%'.$term.'%')->orWhere('StoreName', 'LIKE', '%'.$term.'%')
            ->take(10)->get();
        foreach ($queries as $query)
        {
            $results[] =  ['id' => $query->CustomerId, 'value' => $query->CustomerPastelCode,'extra' => $query->StoreName,'customerId'=>$query->CustomerId,'crLimit'=>$query->CreditLimit,'balDue'=>$query->BalanceDue,'License'=>$query->UserField5,'Email'=>$query->Email ];
        }
        if(count($results))
            return $results;
        else
            return ['value'=>'No Result Found','id'=>''];
    }
    public function copyorder($orderid)
    {
        // $queryCustomers = DB::connection('sqlsrv3')->table("viewtblCustomers" )
        //     ->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute','mnyCustomerGp','ID','Warehouse','PriceListName','CustomerOnHold','termsAndList')
        //     ->where('StatusId',1)
        //     ->orderBy('CustomerPastelCode','ASC')->get();

        return view('dims/copyorder')
            ->with('orderid',$orderid);

    }
    public function insertCopyorder(Request $request){
        $custCode = $request->get('custCode');
        $orderid = $request->get('orderid');
        $deliverydate = $request->get('deliverydate');
        $recalcprices = $request->get('recalcprice');

        $userid = Auth::user()->UserID;
        $username = Auth::user()->UserName;

        $returnmsg= DB::connection('sqlsrv3')
            ->select('exec spCopyOrder ?,?,?,?,?,?',
                array($orderid,$custCode,(new \DateTime($deliverydate))->format('Y-m-d') ,$userid,$recalcprices,$username)
            );

        return response()->json($returnmsg);
    }
    public function getextracomunsforItems(Request $request)
    {
        $custCode = $request->get('custCode');
        $productCode = $request->get('productCode');
        if (config('app.IS_API_BASED')) {
            $returnCustomerRoute = $this->apiGetextracomunsforItems([
                'custCode' => $custCode,
                'productCode' => $productCode,
            ]);
        } else {
            $returnCustomerRoute = DB::connection('sqlsrv3')
            ->select('exec spGetproductExtraInfo ?,?',
                array($productCode,$custCode)
            );
            // ->select("EXEC spCustomerRouteAndAllRoutesByPriority '".$customerCode."'");
        }

        return response()->json($returnCustomerRoute);
    }
    public function isClosedRoute(Request $request)
    {
        $OrderType= $request->get('orderType');
        $routeId= $request->get('routeId');
        $inputCustAcc = $request->get('inputCustAcc');
        if (config('app.IS_API_BASED')) {
            $count = $this->apiIsClosedRoute([
                'DeliveryDate' => (new \DateTime($request->get('delDate')))->format('Y-m-d'),
                'OrderTypeId' => $OrderType,
                'RouteId' => $routeId,
                'CustomerPastelCode' => $inputCustAcc,
            ]);
        } else {
            $islosed =DB::connection('sqlsrv3')->table("tblDeliveryDateRouting")->select('Closed')
                ->where('DeliveryDate',(new \DateTime($request->get('delDate')))->format('Y-m-d') )
                ->Where('OrderTypeId',$OrderType )
                ->Where('RouteId',$routeId )->take(1)->get();
            $customerRouteCheck =DB::connection('sqlsrv3')->table("viewtblCustomers")->select('Routeid')
                ->where('CustomerPastelCode',$inputCustAcc)
                ->take(1)->get();
            $count = array();
            if (count($islosed) < 1) {
                $count['isClosed']= 0;
                $count['routeId']= $customerRouteCheck[0]->Routeid;
            } else {
                $count['isClosed']= $islosed[0]->Closed;
                $count['routeId']= $customerRouteCheck[0]->Routeid;
            }
        }
        $count['routeOnOrder'] = $routeId;

        return $count;
    }
    public function CustomerDescription(Request $request)
    {
        //$term = $request->input('custDescription');
        $term = $request->get('term','');;

        $results = array();//vwtblCustomers
        $queries =DB::connection('sqlsrv3')->table("tblCustomers")
            ->where('StoreName', 'LIKE', '%'.$term.'%')->orWhere('CustomerPastelCode', 'LIKE', '%'.$term.'%')
            ->take(5)->get();
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->CustomerId, 'value' => $query->StoreName,'extra' => $query->CustomerPastelCode,'customerId'=>$query->CustomerId,'crLimit'=>$query->CreditLimit,'balDue'=>$query->BalanceDue,'License'=>$query->UserField5,'Email'=>$query->Email];
        }
        if(count($results))
            return $results;
        else
            return ['value'=>'No Result Found','id'=>''];
        //return response()->json($results);
        //return Response::json($results);
    }
    public function getCustomerRouteWithOtherRoutesByPriority(Request $request)
    {
        $customerCode = $request->get('customerCode');
        if (config('app.IS_API_BASED')) {
            $returnCustomerRoute = $this->apiGetCustomerRouteWithOtherRoutesByPriority([
                'CustomerCode' => $customerCode
            ]);
        } else {
            $returnCustomerRoute = DB::connection('sqlsrv3')
            ->select('exec spCustomerRouteAndAllRoutesByPriority ?',
                array($customerCode)
            );
            // ->select("EXEC spCustomerRouteAndAllRoutesByPriority '".$customerCode."'");
        }

        return response()->json($returnCustomerRoute);

    }
    public function ProductCode(Request $request)
    {
        $term = $request->get('term','');
        // $term = $request->get('term','');

        $results = array();
        $queries =DB::connection('sqlsrv3')->select("Select top 30 * from viewActiveProductWithVat WHERE PastelCode LIKE '%$term%' " );
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->ProductId, 'value' => $query->PastelCode,'extra' => $query->PastelDescription,'unitSize'=>$query->UnitSize,'Tax'=>$query->Tax,'Cost'=>$query->Cost,'QtyInStock'=>$query->QtyInStock,'margin'=>$query->Margin,'Alcohol'=>$query->Alcohol];
        }
        if(count($results))
            return $results;
        else
            return ['value'=>'No Result Found','id'=>''];

    }
    public function ProductDescription(Request $request)
    {

        $term = $request->get('term','');
        $results = array();
        $queries =DB::connection('sqlsrv3')->select("Select top 30 * from viewActiveProductWithVat WHERE PastelDescription LIKE '%$term%'");

        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->ProductId, 'value' => trim($query->PastelDescription),'extra' => $query->PastelCode,'unitSize'=>$query->UnitSize,'Tax'=>$query->Tax,'Cost'=>$query->Cost,'QtyInStock'=>$query->QtyInStock,'margin'=>$query->Margin,'Alcohol'=>$query->Alcohol];
        }
        if(count($results))
            return $results;
        else
            return ['value'=>'No Result Found','id'=>''];

    }

    public function returnProductPrice(Request $request)
    {
        $customerCode = $request->get('customerID');
        $productCode = $request->get('productCode');
        $warehouse = $request->get('warehouseid');
        $deliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        if (config('app.IS_API_BASED')) {
            $returnPrice = $this->apiReturnProductPrice([
                'CustomerCode' => $customerCode,
                'ProductCode' => $productCode,
                'DelvDate' => $deliveryDate,
                'Warehouseid' => $warehouse,
            ]);
        } else {
            $userid = Auth::user()->UserID;
            $returnPrice = DB::connection('sqlsrv3')
                ->select('exec spCustomerPriceLookUp ?,?,?,?,?',
                    array($deliveryDate,$productCode,$customerCode,$warehouse,$userid)
                );
        }

        return response()->json($returnPrice);

    }

    /**
     * function that gets last 10 invoices for a customer  --Deprecated
     */
    public function getCustomerPast10Invoices(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $orderID = $request->get('orderID');
        $returnPastInvoices = DB::connection('sqlsrv3')
            ->select('exec spGetCustomerPastInvoices ?',
                array($customerCode)
            );

        return response()->json($returnPastInvoices);
    }
    /*
     * Deprecated
     */
    public function getCustomerSpecials(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $deliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d H:m:s');
        $returnPastInvoices = DB::connection('sqlsrv3')
            ->select('exec spCustomerDateDrivenSpecials ?,?',
                array($customerCode,$deliveryDate)
            );

        return response()->json($returnPastInvoices);

    }
    public function priceLookUpOntab(Request $request)
    {
        $prodCode = $request->get('prodCode');
        $customerCode = $request->get('customerCode');
        $deliveryDate = $request->get('deliveryDate');
        $customerID = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$customerCode)->get();
        $productID = DB::connection('sqlsrv3')->table('tblProducts')->select('ProductId')->where('PastelCode',$prodCode)->get();
        $returnPrice = DB::connection('sqlsrv3')
            ->select('exec spCustomerPriceLookUp ?,?,?,?,?',
                array($deliveryDate,$productID[0]->ProductId,$customerID[0]->CustomerId,1,1)
            );

        return response()->json($returnPrice);
    }
    public function productPriceLookUp(Request $request)
    {
        $prodCode = $request->get('productCode');
        $customerCode = $request->get('customerCode');
        $prodId = $request->get('prodId');
        $custId = $request->get('custId');
        $deliveryDate = (new \DateTime())->format('Y-m-d');
        $userid = Auth::user()->UserID;
        $returnCustProdPrice = DB::connection('sqlsrv3')
            ->select('exec spCustomerPriceLookUp ?,?,?,?,?',
                array($deliveryDate,$prodCode,$customerCode,-1,$userid)
            );

        $GetProductPrices= DB::connection('sqlsrv3')
            ->select("EXEC spGeneralPriceCheck '".$prodCode."'");

        $GetProductStockOnHand= DB::connection('sqlsrv3')
            ->select("EXEC spGetProductStockOnHand '".$prodCode."',".$userid);

        $GetCurrentPrices= DB::connection('sqlsrv3')
            ->select("select * from  dbo.fnCustomerCurrentPrice ($prodId,$custId,'$deliveryDate')");

        // dd("select * from  dbo.fnCustomerCurrentPrice ($prodId,$custId,'$deliveryDate')");
        $outPut['priceList'] = $GetProductPrices;
        $outPut['productPriceForCust'] = $returnCustProdPrice;
        $outPut['stock'] = $GetProductStockOnHand;
        $outPut['currentPrices'] = $GetCurrentPrices;

        return $outPut;
    }

    public function updateDiscount(Request $request)
    {
        $orderID = $request->get('OrderId');
        $disc = $request->get('Disc');
        if (config('app.IS_API_BASED')) {
            $this->apiUpdateDiscount([
                'OrderId' => $orderID,
                'Disc' => $disc
            ]);
        } else {
            DB::connection('sqlsrv3')->table('tblOrders')
                ->where('OrderID', $orderID )
                ->update(['Disc' => $disc]);
        }

        return $disc;
    }

    /*
     * Deprecated
     */
    public function getGroupSpecials(Request $request)
    {
        $customerCode = $request->get('customerCode');

        $deliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d H:m:s');
        $returnPastInvoices = DB::connection('sqlsrv3')
            ->select('exec spCustomerGroupSpecials ?,?',
                array($customerCode,$deliveryDate)
            );
        //->select("EXEC spCustomerGroupSpecials '".$customerCode."','".$deliveryDate."'");
        return response()->json($returnPastInvoices);

    }
    /*
     * From  getGroupSpecials and getCustomerSpecials
     */
    public function combinedSpecials(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $deliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        if (config('app.IS_API_BASED')) {
            $output = $this->apiCombinedSpecials([
                'CustomerCode' => $customerCode,
                'DelvDate' => $deliveryDate
            ]);
        } else {
            $returnGroupSpecials= DB::connection('sqlsrv3')
                ->select('exec spCustomerGroupSpecials ?,?',
                    array($customerCode,$deliveryDate)
                );
            $returnCustomer = DB::connection('sqlsrv3')
                ->select('exec spCustomerDateDrivenSpecials ?,?',
                    array($customerCode,$deliveryDate)
                );
            $returnPastInvoices = DB::connection('sqlsrv3')
                ->select('exec spGetCustomerPastInvoices ?',
                    array($customerCode)
                );

            $customerContacts= DB::connection('sqlsrv3')->table('tblCustomers')->select('BuyerContact','BuyerTelephone','CellPhone')->where('CustomerPastelCode',$customerCode)->get();

            $output['customerSpecials'] = $returnCustomer;
            $output['GroupSpecials'] = $returnGroupSpecials;
            $output['pastInvoices'] = $returnPastInvoices;
            $output['contacts'] = $customerContacts;
        }

        return $output;
    }

    public function getDeliverTypes()
    {
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        return response()->json($deliverTypes);
    }
    public function getCustomerID(Request $request)
    {
        $customerCode = $request->get('customerCode');
        return $this->getIDs("tblCustomers","CustomerId","CustomerPastelCode",$customerCode);
    }

    /**
     * @param $table name of the table
     * @param $columnWithId column to return
     * @param $criteria column to filter on a WHERE clause
     * @param $lookup parameter to look up
     * @return json
     */
    public function getIDs($table,$columnWithId,$criteria,$lookup){
        $ID= DB::connection('sqlsrv3')->table($table)->select($columnWithId)->where($criteria,$lookup)->get();

        return response()->json($ID);
    }

    public function insertOrderHearder(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $OrderDate = (new \DateTime($request->get('orderDate')))->format('Y-m-d');
        $DeliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $RouteId = $request->get('routeId');
        $LateOrder = $request->get('OrderType');
        $OrderNo = $request->get('orderNo');
        $statement = $request->get('statement');
        $discount = $request->get('discount');
        $OrderNo = str_replace("'", " ", $OrderNo);
        $DeliveryAddressID =0;
        if (config('app.IS_API_BASED')) {
            $response = $this->apiInsertOrderHearder([
                'CustomerCode' => $customerCode,
                'LateOrder' => $LateOrder,
                'DeliveryDate' => $DeliveryDate,
                'OrderDate' => $OrderDate,
                'DeliveryAddressID' => $DeliveryAddressID,
            ]);
            $output['orderId'] = $response['Result']['Table']['ID'];
            $output['singleAddress'] = $response['Result']['Table1'];
            $output['counter'] = $response['Result']['Table2'];
        } else {
            $userID =  Auth::user()->UserID;
            //$customerID = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$customerCode)->get();
            //$Routeid = DB::connection('sqlsrv3')->table('tblCustomers')->select('Routeid')->where('CustomerPastelCode',$customerCode)->get();
            //DB::beginTransaction();

            // $returnPastInvoices = DB::connection('sqlsrv3')->select("EXEC spCRUDOrderHeaders 0,'".$customerCode."',".$DeliveryAddressID.",'".$OrderDate."','".$DeliveryDate."',".$LateOrder.",'".$OrderNo."',0,'".$statement."'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".",".$userID.",0,".$discount);
            $returnPastInvoices = DB::connection('sqlsrv3')
                //->select("EXEC spCRUDOrderHeaders 0,'".$customerCode."',".$DeliveryAddressID.",'".$OrderDate."','".$DeliveryDate."',".$LateOrder.",'".$OrderNo."',0,'".$statement."'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".",".$userID.",0,0.0");
                ->select('exec spCRUDOrderHeaders ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                    array(0,$customerCode,$DeliveryAddressID,$OrderDate,$DeliveryDate,$LateOrder,$OrderNo,0,$statement,'0','0','0','0','0','0',$userID,0,$discount)
                );


            if(strlen($returnPastInvoices[0]->ID > 1)){
                (new DimsCommon())->lockOrder($returnPastInvoices[0]->ID);
            }
            $zero = 0;
            $countAddress = DB::connection('sqlsrv3')
                // ->select("EXEC spCrudDeliveryAddress ".$zero.",'00','00','000','000','000',00,00,'00','".$customerCode."',00,'Count'");
                ->select('exec spCrudDeliveryAddress ?,?,?,?,?,?,?,?,?,?,?,?',
                    array($zero,'00','00','000','000','000',00,00,'00',$customerCode,00,'Count')
                );
            $custSingleAddress = DB::connection('sqlsrv3')
                ->select('exec spCrudDeliveryAddress ?,?,?,?,?,?,?,?,?,?,?,?',
                    array($zero,'00','00','000','000','000',00,00,'00',$customerCode,00,'Select')
                );

            $output['orderId'] = $returnPastInvoices[0]->ID;
            $output['counter'] = $countAddress[0];
            $output['singleAddress'] = $custSingleAddress[0];
        }

        return $output;
    }

    public function orderheaderAndOrderLines(Request $request)
    {
        $orderlines = $request->get('orderlines');
        $orderheaders = $request->get('orderheaders');
        $orderId = $request->get('OrderId');
        if (is_array($orderlines)) {
            $orderheaderxml = $this->toxml($orderheaders, "xml", array("result"));
            $orderlinesrxml = $this->toxml($orderlines, "xml", array("result"));
            if (config('app.IS_API_BASED')) {
                $orderlinesrxml = $this->toxml($orderlines, "xml", array("result"));
                $orderheaderxml = $this->toxml($orderheaders, "xml", array("result"));
                $outPut = $this->apiOrderheaderAndOrderLines([
                    'OrderId' => $orderId,
                    'XmlOrderLines' => $orderlinesrxml,
                    'XmlOrderHeaders' => $orderheaderxml,
                ]);
            } else {
                $userid = Auth::user()->UserID;
                $userName = Auth::user()->UserName;
                $getResult = DB::connection('sqlsrv4')
                    ->select("EXEC spXmlOrderHeadersAndLines " . $orderId . ",'" . $orderlinesrxml . "','" . $orderheaderxml . "','" . $userName . "'," . $userid);
                $outPut['result'] = $getResult[0]->Result;
                $outPut['Error'] = $getResult[0]->error;
                $outPut['Extras'] = $getResult[0]->Extras;
            }
        } else {
            $outPut['result'] = "Success";
            $outPut['Error'] = "Success";
            $outPut['Extras'] = "";
        }

        return $outPut;
    }
    public function checkstockonorders(Request $request){
        $orderlines = $request->get('orderlinesprodValidations');
        $orderheaderxml = $this->toxml($orderlines, "xml", array("result"));

        //dd($orderheaderxml);
        $getResult = DB::connection('sqlsrv4')
            ->select("EXEC spCheckStockBeforeSavingOrder '" . $orderheaderxml . "'");
        return response()->json($getResult);
    }
    public function checkZeroCostOnOrder(Request $request)
    {
        $outPut = [];
        $orderlines = $request->get('orderlines');
        $OrderId = $request->get('OrderId');
        if (config('app.IS_API_BASED')) {
            $orderlinesrxml = '';
            if (is_array($orderlines)) {
                $orderlinesrxml = $this->toxml($orderlines, "xml", array("result"));
            }
            $outPut = $this->apiCheckZeroCostOnOrder([
                'XmlPassed' => $orderlinesrxml,
                'OrderId' => $OrderId,
            ]);
        } else {
             $v = new \App\Http\Controllers\SalesForm();
            $hasauthcosts = $v->getThings(Auth::user()->GroupId,'Auth Zero Cost Grid');
            if ($hasauthcosts =="1") {
                if (is_array($orderlines)) {
                    $orderlinesrxml = $this->toxml($orderlines, "xml", array("result"));
                    $getResult = DB::connection('sqlsrv4')
                        ->select("EXEC spXmlProductHavingZeroCost " . $OrderId . ",'" . $orderlinesrxml . "'");
                    if(count($getResult) > 0) {
                        $outPut['result'] = "SUCCESS";
                        $outPut['data'] = $getResult;
                    } else {
                        $outPut['result'] = "Nothing";
                    }
                } else {
                    $outPut['result'] = "Nothing";
                }
            } else {
                $outPut['result'] = "Nothing";
            }
        }

        return $outPut;
    }
    public function insertHeaderForOtherTrans(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $OrderDate = (new \DateTime($request->get('orderDate')))->format('Y-m-d');
        $DeliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $RouteId = $request->get('routeId');
        $LateOrder = $request->get('OrderType');
        $OrderNo = $request->get('orderNo');
        $statement = $request->get('statement');
        $DeliveryAddressID =0;
        $userID =  Auth::user()->UserID;
        $customerSelectedDelDate = $request->get('customerSelectedDelDate');
        $transType = 7;
        //$customerID = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$customerCode)->get();
        //$Routeid = DB::connection('sqlsrv3')->table('tblCustomers')->select('Routeid')->where('CustomerPastelCode',$customerCode)->get();
        //DB::beginTransaction();

        $returnPastInvoices = DB::connection('sqlsrv3')->select("EXEC spCRUDHeadersForOtherTransactions 0,'".$customerCode."',".$DeliveryAddressID.",'".$OrderDate."','".$DeliveryDate."',".$LateOrder.",'".$OrderNo."',0,'".$statement."'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".",".$userID.",0,".$transType.",'".$customerSelectedDelDate."'");
        //DB::commit();
        //(new DimsCommon())->lockOrder($returnPastInvoices->Id);


        if(strlen($returnPastInvoices[0]->ID > 1)){
            (new DimsCommon())->lockOrder($returnPastInvoices[0]->ID);
        }
        $zero = 0;
        $countAddress = DB::connection('sqlsrv3')
            ->select("EXEC spCrudDeliveryAddress ".$zero.",'00','00','000','000','000',00,00,'00','".$customerCode."',00,'Count'");
        $custSingleAddress = DB::connection('sqlsrv3')
            ->select("EXEC spCrudDeliveryAddress ".$zero.",'00','00','000','000','000',00,00,'00','".$customerCode."',00,'Select'");


        $output['orderId'] = $returnPastInvoices[0]->ID;
        $output['counter'] = $countAddress[0];
        $output['singleAddress'] = $custSingleAddress[0];
        return $output;
    }
    public function UpdateOrderHearder(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $OrderDate = (new \DateTime($request->get('orderDate')))->format('Y-m-d');
        $DeliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $RouteId = $request->get('routeId');
        $LateOrder = $request->get('OrderType');
        $OrderNo = $request->get('orderNo');
        $orderId = $request->get('orderId');
        $messagebox = $request->get('messagebox');
        $discount = $request->get('discount');
        $OrderNo = str_replace("'", " ", $OrderNo);
        $awaitingStock = $request->get('awaitingStock');
        $address1hidden = $request->get('address1hidden');
        $address2hidden = $request->get('address2hidden');
        $address3hidden = $request->get('address3hidden');
        $address4hidden = $request->get('address4hidden');
        $address5hidden = $request->get('address5hidden');
        $address1hidden = str_replace("'","",$address1hidden);
        $address2hidden = str_replace("'","",$address2hidden);
        $address3hidden = str_replace("'","",$address3hidden);
        $address4hidden = str_replace("'","",$address4hidden);
        $address5hidden = str_replace("'","",$address5hidden);
        $DeliveryAddressID = $request->get('DeliveryAddressID');
        if(strlen($DeliveryAddressID ) < 1 || $DeliveryAddressID == "Null"){
            $DeliveryAddressID = "NULL";
        }
        if (strlen($address1hidden) < 1)
        {
            $address1hidden = "NULL";
        }
        if (strlen($address2hidden) < 1)
        {
            $address2hidden = "NULL";
        }
        if (strlen($address3hidden) < 1)
        {
            $address3hidden = "NULL";
        }
        if (strlen($address4hidden) < 1)
        {
            $address4hidden = "NULL";
        }
        if (strlen($address5hidden) < 1)
        {
            $address5hidden = "NULL";
        }
        $userID =  Auth::user()->UserID;
        $address1hidden =  substr($address1hidden,0,28);
        $address2hidden =  substr($address2hidden,0,28);
        $address3hidden =  substr($address3hidden,0,28);
        $address4hidden =  substr($address4hidden,0,28);
        $address5hidden =  substr($address5hidden,0,28);
        $statement = 'Update';
        $OrderNo = str_replace("'", " ", $OrderNo);
        $host = gethostname();
        if (strlen(trim($RouteId)) < 1)
        {
            $Routeidnew = DB::connection('sqlsrv3')->table('viewtblCustomers')->select('Routeid')->where('CustomerPastelCode',$customerCode)->get();
            $RouteId = $Routeidnew[0]->Routeid;
        }

        $return = DB::connection('sqlsrv3')->statement("EXEC spCRUDOrderHeaders "
            .$orderId.",'".$customerCode."',".$DeliveryAddressID.",'".$OrderDate."','".$DeliveryDate."',".$LateOrder.",'".
            $OrderNo."',".$RouteId.",'".$statement."','".$address1hidden."','".$address2hidden."','".$address3hidden."','".$address4hidden."','".$address5hidden."','".$messagebox."',".$userID.",".$awaitingStock.",".$discount);
        (new ConsoleManagement())->logMessage(2,1,0,'Order Type On Update Process :'.$LateOrder.' AND Route ID '.$RouteId,0,$orderId,0,$customerCode,Auth::user()->UserID,
            0,0,0,0,Auth::user()->UserID,$OrderNo ,  1, $orderId,"'".$host."'",'0');
        return response()->json($return);
    }
    public function updateOrderHeaderForOtherTransactions(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $OrderDate = (new \DateTime($request->get('orderDate')))->format('Y-m-d');
        $DeliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $RouteId = $request->get('routeId');
        $LateOrder = $request->get('OrderType');
        $OrderNo = $request->get('orderNo');
        $orderId = $request->get('orderId');
        $messagebox = $request->get('messagebox');
        $customerSelectedDelDate = $request->get('customerSelectedDelDate');
        $transType = 7;

        $awaitingStock = $request->get('awaitingStock');
        $address1hidden = $request->get('address1hidden');
        $address2hidden = $request->get('address2hidden');
        $address3hidden = $request->get('address3hidden');
        $address4hidden = $request->get('address4hidden');
        $address5hidden = $request->get('address5hidden');
        $address1hidden = str_replace("'","",$address1hidden);
        $address2hidden = str_replace("'","",$address2hidden);
        $address3hidden = str_replace("'","",$address3hidden);
        $address4hidden = str_replace("'","",$address4hidden);
        $address5hidden = str_replace("'","",$address5hidden);
        $DeliveryAddressID = $request->get('DeliveryAddressID');
        if(strlen($DeliveryAddressID ) < 1 || $DeliveryAddressID == "Null"){
            $DeliveryAddressID = "NULL";
        }
        if (strlen($address1hidden) < 1)
        {
            $address1hidden = "NULL";
        }
        if (strlen($address2hidden) < 1)
        {
            $address2hidden = "NULL";
        }
        if (strlen($address3hidden) < 1)
        {
            $address3hidden = "NULL";
        }
        if (strlen($address4hidden) < 1)
        {
            $address4hidden = "NULL";
        }
        if (strlen($address5hidden) < 1)
        {
            $address5hidden = "NULL";
        }
        if (strlen($customerSelectedDelDate) < 1)
        {
            $customerSelectedDelDate = "NULL";
        }
        $userID =  Auth::user()->UserID;
        $address1hidden =  substr($address1hidden,0,28);
        $address2hidden =  substr($address2hidden,0,28);
        $address3hidden =  substr($address3hidden,0,28);
        $address4hidden =  substr($address4hidden,0,28);
        $address5hidden =  substr($address5hidden,0,28);
        $statement = 'Update';
        $host = gethostname();
        // dd($orderId);
        $return = DB::connection('sqlsrv3')->statement("EXEC spCRUDHeadersForOtherTransactions ".$orderId.",'".$customerCode."',".$DeliveryAddressID.",'".$OrderDate."','".$DeliveryDate."',".$LateOrder.",'".
            $OrderNo."',".$RouteId.",'".$statement."','".$address1hidden."','".$address2hidden."','".$address3hidden."','".$address4hidden."','".$address5hidden."','".$messagebox."',".$userID.",0,".$transType.",'".$customerSelectedDelDate."'");

        (new ConsoleManagement())->logMessage(2,1,0,'Order Type On Update Process :'.$LateOrder.' AND Route ID '.$RouteId,0,$orderId,0,$customerCode,Auth::user()->UserID,
            0,0,0,0,Auth::user()->UserID,$OrderNo ,  1, $orderId,"'".$host."'",'0');
        return response()->json($return);
    }
    //Sales orders only
    public function checkIfOrderExists(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $OrderDate = (new \DateTime($request->get('orderDate')))->format('Y-m-d');
        $DeliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $LateOrder = $request->get('OrderType');
        $OrderNo = $request->get('orderNo');
        $statement = $request->get('statement');
        $DeliveryAddressID = 0;
        $OrderNo = str_replace("'", " ", $OrderNo);
        if (config('app.IS_API_BASED')) {
            $returnCounts = 0;
        } else {
            $userID =  Auth::user()->UserID;
            $returnCounts = DB::connection('sqlsrv3')
                //->select("EXEC spCRUDOrderHeaders 0,'".$customerCode."',".$DeliveryAddressID.",'".$OrderDate."','".$DeliveryDate."',".$LateOrder.",'".$OrderNo."',0,'".$statement."'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".",".$userID.",0,0.0");
                ->select('exec spCRUDOrderHeaders ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                    array(0,$customerCode,$DeliveryAddressID,$OrderDate,$DeliveryDate,$LateOrder,$OrderNo,0,$statement,'0','0','0','0','0','0',$userID,0,0)
                );
        }

        return response()->json($returnCounts);
    }
    //check if other transactions exists ,sales orders are not part of this
    public function checkIfTransactionsExists(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $OrderDate = (new \DateTime($request->get('orderDate')))->format('Y-m-d');
        $DeliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $LateOrder = $request->get('OrderType');
        $OrderNo = $request->get('orderNo');
        $statement = $request->get('statement');
        $DeliveryAddressID = 0;
        $userID =  Auth::user()->UserID;

        $returnCounts = DB::connection('sqlsrv3')->select("EXEC spCRUDHeadersForOtherTransactions 0,'".$customerCode."',".$DeliveryAddressID.",'".$OrderDate."','".$DeliveryDate."',".$LateOrder.",'".$OrderNo."',0,'".$statement."'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".","."'0'".",".$userID.",0,7,checkingmess");
        return response()->json($returnCounts);
    }
    public function insertOrderDetails(Request $request)
    {
        $OrderId= $request->get('OrderId');
        $OrderDetailId = $request->get('OrderDetailId');
        $CustomerCode = $request->get('CustomerCode');
        $ProductCode = $request->get('ProductCode');
        $Qty = $request->get('Qty');
        $Price = $request->get('Price');
        $LineDisc = $request->get('LineDisc');
        $Comment= $request->get('Comment');
        $UnitCount= $request->get('UnitCount');//Please chek where this is pulling from
        $statement = $request->get('statement');
        $userID = Auth::user()->UserID;
        //$CustomerId = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$CustomerCode)->get();
        // $productID = DB::connection('sqlsrv3')->table('tblProducts')->select('ProductId')->where('PastelCode',$ProductCode)->get();
        // DB::beginTransaction();
        $insertOrderDetails = DB::connection('sqlsrv3')
            ->select("EXEC spCRUDOrderDetails ".$OrderId.",".$OrderDetailId .",'".$CustomerCode."','".$ProductCode."',
            ".$Qty.",".$Qty.",".$Qty.",".$Price.",".$LineDisc.",'".$Comment."',".$userID.",".$UnitCount.",'Insert'");
        // DB::commit();
        return response()->json($insertOrderDetails);

    }
    public function DeleteOrderDetails(Request $request)
    {
        $OrderId= $request->get('OrderId');
        $OrderDetailId = $request->get('OrderDetailId');
        $Qty = 0;
        $Price = 0;
        $LineDisc = 0;
        $CustomerId = 0;
        $productID = 0;
        $UnitCount = 0;
        $Comment = "delete line";
        $userID = Auth::user()->UserID;
        //DB::beginTransaction();

        if(strlen($OrderDetailId) > 1)
        {
            $insertOrderDetailDelete = DB::connection('sqlsrv3')
                ->statement("EXEC spCRUDOrderDetails ".$OrderId.",".$OrderDetailId .",'".$CustomerId."','".$productID."',
            ".$Qty.",".$Qty.",".$Qty.",".$Price.",".$LineDisc.",'".$Comment."',".$userID.",".$UnitCount.",'Delete'");
            //if it didn't delete 07 Jan 2018 use laravel delete
            //$insertOrderDetailDelete = false;
            if(!$insertOrderDetailDelete)
            {
                DB::connection('sqlsrv3')->table('tblOrderDetails')->where('OrderDetailId',$OrderDetailId)->where('Loaded',0)->delete();
                $checkIfThereIsOrderDetailID = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('OrderDetailId')->where('OrderDetailId',$OrderDetailId)->get();
                if(count($checkIfThereIsOrderDetailID) < 1)
                {
                    $host = 'Browser';
                    (new ConsoleManagement())->logMessage(2,1,0,'Line ID '.$OrderDetailId.' deleted',0,$OrderId,0,$CustomerId,Auth::user()->UserID,
                        0,0,0,0,Auth::user()->UserID,$OrderId ,  1, $OrderId,"'".$host."'",'0');
                    $outPut['deletedId'] = $OrderDetailId;
                    return $outPut;
                }
                else{
                    $outPut['deletedId'] = "FAILED";
                    return $outPut;
                }
            }
            else
            {
                $outPut['deletedId'] = $OrderDetailId;
                return $outPut;
            }


            // DB::connection('sqlsrv3')->table('tblOrderDetails')->where('OrderDetailId',$OrderDetailId)->delete();
        }

        //DB::commit();
        // $outPut['deletedId'] = $OrderDetailId;
        //return $outPut;

    }

    public function deleteByHiddenToken(Request $request)
    {
        $orderId = $request->get('orderId');
        $hiddentToken = $request->get('hiddenToken');
        if (config('app.IS_API_BASED')) {
            $outPut = $this->apiDeleteByHiddenToken([
                'Orderid' => $orderId,
                'HiddenToken' => $hiddentToken,
            ]);
        } else {
            $getResult = DB::connection('sqlsrv3')
                ->select("EXEC spDeleteHiddenToken ".$orderId.",".$hiddentToken);

            $outPut['result'] = $getResult[0]->Result;
        }

        return $outPut;
    }

    public function DeleteOrderDetailsOrtherTrans(Request $request)
    {
        $OrderId= $request->get('OrderId');
        $OrderDetailId = $request->get('OrderDetailId');
        $Qty = 0;
        $Price = 0;
        $LineDisc = 0;
        $CustomerId = 0;
        $productID = 0;
        $UnitCount = 0;
        $Comment = "delete line";
        $userID = Auth::user()->UserID;
        //DB::beginTransaction();

        if(strlen($OrderDetailId) > 1)
        {
            $insertOrderDetailDelete = DB::connection('sqlsrv3')
                ->statement("EXEC spCRUDOrderDetailsForOtherTransactions ".$OrderId.",".$OrderDetailId .",'".$CustomerId."','".$productID."',
            ".$Qty.",".$Qty.",".$Qty.",".$Price.",".$LineDisc.",'".$Comment."',".$userID.",".$UnitCount.",'2018-01-01','2018-01-01',0.0,'Delete'");
            //if it didn't delete 07 Jan 2018 use laravel delete
            //$insertOrderDetailDelete = false;
            if(!$insertOrderDetailDelete)
            {
                DB::connection('sqlsrv3')->table('tblOrderDetailsForOtherTransactions')->where('OrderDetailId',$OrderDetailId)->delete();
                $checkIfThereIsOrderDetailID = DB::connection('sqlsrv3')->table('tblOrderDetailsForOtherTransactions')->select('OrderDetailId')->where('OrderDetailId',$OrderDetailId)->get();
                if(count($checkIfThereIsOrderDetailID) < 1)
                {
                    $host = 'Browser';
                    (new ConsoleManagement())->logMessage(2,1,0,'Line ID '.$OrderDetailId.' deleted Q',0,$OrderId,0,$CustomerId,Auth::user()->UserID,
                        0,0,0,0,Auth::user()->UserID,$OrderId ,  1, $OrderId,"'".$host."'",'0');
                    $outPut['deletedId'] = $OrderDetailId;
                    return $outPut;
                }
                else{
                    $outPut['deletedId'] = "FAILED";
                    return $outPut;
                }
            }
            else
            {
                $outPut['deletedId'] = $OrderDetailId;
                return $outPut;
            }


            // DB::connection('sqlsrv3')->table('tblOrderDetails')->where('OrderDetailId',$OrderDetailId)->delete();
        }

        //DB::commit();
        // $outPut['deletedId'] = $OrderDetailId;
        //return $outPut;

    }
    public function getCustomerOderpattern(Request $request)
    {
        $CustomerCode = $request->get('CustomerCode');
        $orderID = $request->get('orderID');
        $DeliveryAddressIId = $request->get('DeliveryAddressIId');
        $CustomerId = $request->get('CustomerId');
        if (strlen($DeliveryAddressIId) < 1) {
            $DeliveryAddressIId = "NULL";
        }
        $CustomerCode = str_replace("'", "''", $CustomerCode);

        if (config('app.IS_API_BASED')) {
            $GetOrderPattern = $this->apiGetCustomerOderpattern([
                'Customerid' => $CustomerId,
                'OrderId' => $orderID,
                'addressId' => $DeliveryAddressIId,
            ]);
        } else {
            $GetOrderPattern = DB::connection('sqlsrv3')
                ->select("Select * from  [dbo].[fnCustomerDefaultOrders]('$CustomerId',$orderID,$DeliveryAddressIId) Order By PushProduct Desc, PastelDescription");
        }
        $output['recordsTotal'] = count($GetOrderPattern);
        $output['data'] = $GetOrderPattern;
        $output['recordsFiltered'] = count($GetOrderPattern);
        $output['draw'] = intval($request->input('draw'));

        return $output;

    }
    public function getOrderListing(Request $request)
    {
        $OrderId = $request->get('OrderId');
        $InvNo = $request->get('InvNo');
        $CustCode = $request->get('CustCode');
        $delDate = $request->get('delDate');
        $userid =Auth::user()->UserID;
        // echo $userid ;
        if(strlen($CustCode)> 0){
            $CustomerId = DB::connection('sqlsrv3')->table('viewtblCustomers')->select('CustomerId')->where('CustomerPastelCode',$CustCode)->get();
            $CustCode = $CustomerId[0]->CustomerId;
        }

        $GetOrderListing= DB::connection('sqlsrv3')
            ->select("EXEC spOrderListing '".$OrderId."','".$InvNo."','".$delDate."','".$CustCode."',".$userid);
        //dd($GetOrderListing);
        $output['recordsTotal'] = count($GetOrderListing);
        $output['data'] = $GetOrderListing;
        $output['recordsFiltered'] = $output['recordsTotal'];

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }

    public function getorderlocksdeleterpage(Request $request)
    {
        return view('dims/orderlockdeletepage');
    }
    public function getOrderLocksForDeletePageData(Request $request){

            $output = DB::connection('sqlsrv3')
                ->select("EXEC spGetOrderLocksForDeleterPage");

            return response()->json($output);
    }
    public function deleteDataForOrderLockPage(Request $request){

        $userid = Auth::user()->UserID;
        $OrderId = $request->get('OrderId');
        DB::connection('sqlsrv3')
        ->statement("EXEC spDeleteOrderLocksDeleterpage ?,?",array($userid,$OrderId));

    }
    public function getOrderListingOtherTrans(Request $request)
    {
        $OrderId = $request->get('OrderId');
        $InvNo = $request->get('InvNo');
        $CustCode = $request->get('CustCode');
        $delDate = $request->get('delDate');
        //dd($OrderId );
        if(strlen($CustCode)> 0){
            $CustomerId = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$CustCode)->get();
            $CustCode = $CustomerId[0]->CustomerId;
        }

        //$orderby = $request->input('order.4.column');
        //$sort['col'] = $request->input('columns.' . $orderby . '.data');
        //$sort['dir'] = $request->input('order.4.dir');
        $GetOrderListing= DB::connection('sqlsrv3')
            ->select("EXEC spOrderListingForOtherTrans '".$OrderId."','".$InvNo."','".$delDate."','".$CustCode."'");
        //dd($GetOrderListing);
        $output['recordsTotal'] = count($GetOrderListing);
        $output['data'] = $GetOrderListing;
        $output['recordsFiltered'] = $output['recordsTotal'];

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }
    public  function customerLookUp(Request $request){
        $columns = array(
            0 =>'CustomerPastelCode',
            1 =>'StoreName',
            2=> 'ContactTel',
            3=> 'ContactPerson',

        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $customersLookUp = DB::connection('sqlsrv3')->select("SELECT [CustomerPastelCode],[StoreName],[ContactTel],[ContactPerson] FROM tblCustomers
                                WHERE CustomerPastelCode like '%{$search}%' or StoreName like '%{$search}%' or ContactTel like '%{$search}%' or
                                ContactPerson like '%{$search}%' ORDER BY $order $dir OFFSET $start ROWS FETCH NEXT $limit ROWS ONLY");

        $countFiltered= DB::connection('sqlsrv3')->select("SELECT [CustomerPastelCode]FROM tblCustomers
                                WHERE  CustomerPastelCode like '%{$search}%' or StoreName like '%{$search}%' or ContactTel like '%{$search}%' or
                                ContactPerson like '%{$search}%'");
        $output['recordsTotal'] = count($customersLookUp);
        $output['data'] = $customersLookUp;
        $output['recordsFiltered'] = count($countFiltered);

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }
    public function onCheckOrderHeader(Request $request)
    {
        $OrderId = $request->get('orderId');
        $InvoiceNumber = $request->get('invoiceNo');
        $orderby = $request->input('order.0.column');
        $sort['col'] = $request->input('columns.' . $orderby . '.data');
        $sort['dir'] = $request->input('order.0.dir');
        $outPut = [];
        if (config('app.IS_API_BASED')) {
            $outPut = $this->apiOnCheckOrderHeader([
                'OrderId' => $OrderId,
                'InvoiceNo' => $InvoiceNumber,
            ]);
        } else {
            $edit = (new SalesForm())->hasAccessToEdit($OrderId);
            $isQoutation = DB::connection('sqlsrv3')
                ->select("select * from tblOrders where OrderId = " . $OrderId." and TreatAsQuotation=1");
            $responseFromOrdeLock = (new DimsCommon())->checkUserLock($OrderId);
            if (count($isQoutation) > 0) {
                $GetOrderHeader = DB::connection('sqlsrv3')
                    ->select("EXEC spReturnInvoiceOrderIdData '" . $OrderId . "','" . $InvoiceNumber . "'");
                $outPut['data'] = $GetOrderHeader;
                $outPut['returns'] = "inserted";
            } else {
                if ($responseFromOrdeLock[0]->orderID == "inserted") {
                    if ($edit == "Yes") {
                        $GetOrderHeader = DB::connection('sqlsrv3')
                            ->select("EXEC spReturnInvoiceOrderIdData '" . $OrderId . "','" . $InvoiceNumber . "'");
                        $outPut['data'] = $GetOrderHeader;
                        $outPut['returns'] = "inserted";
                    } else {
                        $mes = $OrderId . ' has been planned already, please view this order as PDF';
                        $GetOrdermess = DB::connection('sqlsrv3')
                            ->select("Select '$mes' as orderID ");
                        $outPut['data'] = $GetOrdermess;
                        $outPut['returns'] = "Not inserted";
                    }
                } else {
                    $outPut['data'] = $responseFromOrdeLock;
                    $outPut['returns'] = "Not inserted";
                }
            }
        }

        return response()->json($outPut);
    }
    //For Other Transactions
    public function onCheckOrderHeaderForOtherTrans(Request $request)
    {
        $OrderId= $request->get('orderId');
        $InvoiceNumber = $request->get('invoiceNo');
        $orderby = $request->input('order.0.column');
        $sort['col'] = $request->input('columns.' . $orderby . '.data');
        $sort['dir'] = $request->input('order.0.dir');

        $responseFromOrdeLock = (new DimsCommon())->checkUserLock($OrderId);
        if ($responseFromOrdeLock[0]->orderID == "inserted")
        {
            $GetOrderHeader = DB::connection('sqlsrv3')
                ->select("EXEC spReturnInvoiceOrderIdDataForOtherTrans '".$OrderId."','".$InvoiceNumber."'");
            $outPut['data'] = $GetOrderHeader;
            $outPut['returns'] = "inserted";
            return response()->json($outPut);
        }
        else
        {
            $outPut['data'] = $responseFromOrdeLock;
            $outPut['returns'] = "Not inserted";
            return response()->json($outPut);
        }

    }
    public function tempDeliverAddress(Request $request)
    {
        $orderID = $request->get('orderID');
        $address1 = $request->get('address1');
        $address2 = $request->get('address2');
        $address3 = $request->get('address3');
        $address4 = $request->get('address4');
        $address5 = $request->get('address5');
        $address1 =  substr($address1,0,28);
        $address2 =  substr($address2,0,28);
        $address3 =  substr($address3,0,28);
        $address4 =  substr($address4,0,28);
        $address5 =  substr($address5,0,28);
        $Routeid = $request->get('Routeid');

        if (config('app.IS_API_BASED')) {
            $getCallistSp = $this->apiTempDeliverAddress([
                'address1' => $address1,
                'address2' => $address2,
                'address3' => $address3,
                'address4' => $address4,
                'address5' => $address5,
                'Routeid' => $Routeid,
                'OrderId' => $orderID,
            ]);
        } else {
            $salesmanid = Auth::user()->UserID;
            $getCallistSp = DB::connection('sqlsrv3')
                ->statement("EXEC spInsertDeliveryAddressOnTheFly ".$orderID.",'".$address1."','".$address2."','".$address3."','".$address4."','".$address5."',".$Routeid.",".$salesmanid);
        }

        $message = 'OOPS Something wen wrong';
        if ($getCallistSp == true){
            $message = 'Address Created and Saved';
        }

        return $message;
    }
    public function advancedOrderNo(Request $request)
    {
        $OrderId= $request->get('OrderId');
        if (config('app.IS_API_BASED')) {
            $GetOrderNo = $this->apiAdvancedOrderNo([
                'OrderId' => $OrderId
            ]);
        } else {
            $GetOrderNo = DB::connection('sqlsrv3')
                ->select("select OrderNo,Brand,tblBrandOrderInvoice.BrandId from tblBrandOrderInvoice inner join tblBrands on tblBrandOrderInvoice.BrandId = tblBrands.BrandId where OrderId=".$OrderId);
        }

        return response()->json($GetOrderNo);
    }
    public function updateOrderNo(Request $request)
    {
        $OrderId= $request->get('orderId');
        $brandid= $request->get('brandid');
        $orderNO= $request->get('neworderno');
        DB::connection('sqlsrv3')->table('tblBrandOrderInvoice')
            ->where('OrderId', $OrderId)->where('BrandId',$brandid)
            ->update(['OrderNo' => $orderNO]);
    }
    public function getOnOrder(){

        $queryProducts= DB::connection('sqlsrv3')
            ->select("Select PastelCode,PastelDescription,ProductId from viewtblProducts");
     //   dd($queryProducts);
        $queryCustomers = DB::connection('sqlsrv3')
            ->select("Select CustomerPastelCode,StoreName,CustomerId from viewtblCustomers");


        return view('dims/getonorder')
            ->with('products',$queryProducts)
            ->with('customers',$queryCustomers)
            ;
    }
    public function onCheckOrderHeaderDetails(Request $request)
    {
        $OrderId = $request->get('orderId');
        if (config('app.IS_API_BASED')) {
            $GetOrderDetails = $this->apiOnCheckOrderHeaderDetails([
                'OrderId' => $OrderId
            ]);
        } else {
            $GetOrderDetails = DB::connection('sqlsrv3')
                ->select("EXEC spOrderIdLines " . $OrderId);
        }

        return response()->json($GetOrderDetails);
    }
    public function onCheckOrderHeaderDetailsForOtherTrans(Request $request)
    {
        $OrderId= $request->get('orderId');
        $GetOrderDetails= DB::connection('sqlsrv3')
            ->select("EXEC spOrderIdLinesForOtherTrans ".$OrderId);
        return response()->json($GetOrderDetails);
    }
    public function generalPriceChecking(Request $request)
    {
        $productCode= $request->get('productCode');
        $GetProductPrices= DB::connection('sqlsrv3')
            ->select("EXEC spGeneralPriceCheck '".$productCode."'");

        return response()->json($GetProductPrices);

    }
    public function convertToSalesOrder(Request $request)
    {
        $OrderId = $request->get('OrderId');
        $convertQuotationToSalesOrder = DB::connection('sqlsrv3')
            ->select("EXEC spConvertQuotationToSalesOrder '".$OrderId."'");

        return response()->json($convertQuotationToSalesOrder);

    }

    public function generalPriceCheckAndLastCost(Request $request)
    {
        $productCode= $request->get('productCode');
        $custCode= $request->get('custCode');
        if (config('app.IS_API_BASED')) {
            $outPut = $this->apiGeneralPriceCheckAndLastCost([
                'ProductCode' => $productCode,
                'CustCode' => $custCode,
            ]);
        } else {
            $locationId =  Auth::user()->LocationId;
            $GetProductPrices= DB::connection('sqlsrv3')
                ->select("EXEC spGeneralPriceCheck '".$productCode."'");

            $GetLastCost= DB::connection('sqlsrv3')
                ->select("EXEC spLastSellingPrice '".$productCode."','".$custCode."',".$locationId);
            $outPut['pricelists'] = $GetProductPrices;
            $outPut['sellingPrice'] = $GetLastCost;
        }

        return response()->json($outPut);

    }
    public function associatedItem(Request $request)
    {
        $prodCode = $request->get('productCode');
        $customerCode = $request->get('customerCode');
        $deldate = $request->get('delDate');
        $deliveryDate = (new \DateTime($deldate))->format('Y-m-d');
        if (config('app.IS_API_BASED')) {
            $returnCustProdPrice = $this->apiAssociatedItem([
                'Warehouseid' => 1,
                'DelvDate' => $deliveryDate,
                'ProductCode' => $prodCode,
                'CustomerCode' => $customerCode,
            ]);
        } else {
            $userid = Auth::user()->UserID;
            $returnCustProdPrice = DB::connection('sqlsrv3')
                ->select('exec spCustomerPriceLookUpAssociatedItems ?,?,?,?,?',
                    array($deliveryDate,$prodCode,$customerCode,-1,$userid)
                );
        }

        return response()->json($returnCustProdPrice);

    }
    public function getCallList(Request $request)
    {

        $UserId= $request->get('userId');
        $RouteId= $request->get('routeId');
        $UserName= $request->get('UserName');
        $routeName = $request->get('routeName');

        $sessionUserId = Auth::user()->UserID;
        $DeliveryDate=(new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $OrderDate= (new \DateTime($request->get('OrderDate')))->format('Y-m-d');
        //echo "EXEC spCallList '".$UserId."','".$RouteId."','".$DeliveryDate."','".$OrderDate."'";
        $getCallistSp= DB::connection('sqlsrv3')
            ->select("EXEC spCallList '".$UserId."','".$RouteId."','".$DeliveryDate."','".$OrderDate."'");
        DB::connection('sqlsrv3')->table('tblCallistFilters')
            ->where('intSessionUserId',$sessionUserId )
            ->delete();
        DB::connection('sqlsrv3')->table('tblCallistFilters')->insert(
            ['strUserName' => $UserName, 'intUserId' => $UserId,
                'strRouteName' => $routeName,'intRouteId'=>$RouteId,'dteSessionDate'=>$DeliveryDate,
                'intSessionUserId'=>$sessionUserId
            ]);
        return response()->json($getCallistSp);
    }

    public function getCallListNew(Request $request)
    {
        $UserId= $request->get('userId');
        $RouteId= $request->get('routeId');
        $DeliveryDate=(new \DateTime($request->get('deliveryDate')))->format('Y-m-d H:m:s');
        $OrderDate= (new \DateTime($request->get('OrderDate')))->format('Y-m-d H:m:s');
        $getCallistSp= DB::connection('sqlsrv3')
            ->select("EXEC spCallList '".$UserId."','".$RouteId."','".$DeliveryDate."','".$OrderDate."'");

        $output['recordsTotal'] = count($getCallistSp);
        $output['data'] = $getCallistSp;
        $output['recordsFiltered'] = count($getCallistSp);

        $output['draw'] = intval($request->input('draw'));

        return $output;

    }
    public function insertCallID(Request $request)
    {
        $deliverydate = (new \DateTime($request->get('DeivDate')))->format('Y-m-d');
        $CustomerCode = $request->get('CustomerCode');
        $notes = $request->get('notes');
        if(strlen($notes) < 1)
        {
            $notes ='NULL';
        }
        $notes = str_replace("'", ' ', $notes);
        //$CustomerId = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$CustomerCode)->get();
        $Dates= $deliverydate;
        $Show= $request->get('Show'); // i don't know what it does or it means
        $DeliveryAddressId= $request->get('DeliveryAddressId');

        $getCallistSp= DB::connection('sqlsrv3')
            ->statement('exec spInsertInotTempCallOnCallList ?,?,?,?,?',
                array($CustomerCode,$Dates,$Show,$DeliveryAddressId,$notes)
            );
    }
    public function insertDeliveryAddressOnOrder(Request $request)
    {

        $Orderid = $request->get('Orderid');
        $DeliveryAdd1 = $request->get('DeliveryAdd1');
        $DeliveryAdd2 = $request->get('DeliveryAdd2');
        $DeliveryAdd3 = $request->get('DeliveryAdd3');
        $DeliveryAdd4 = $request->get('DeliveryAdd4');
        $DeliveryAdd5 = $request->get('DeliveryAdd5');
        $Routeid = $request->get('Routeid');
        $DeliveryAddressID = $request->get('DeliveryAddressID');
        $CrateAccount = $request->get('CrateAccount');
        $LinkCustomerId = $request->get('LinkCustomerId');
        $SalesmanCode = $request->get('SalesmanCode');
        $insertOrderDetails = DB::connection('sqlsrv3')
            ->select("EXEC spSelectUpdateInsertDeliveryDate ".$Orderid.",'".$DeliveryAdd1 ."','".$DeliveryAdd2."','".$DeliveryAdd3."','
            ".$DeliveryAdd4."','".$DeliveryAdd5."',".$Routeid.",".$DeliveryAddressID.",'".$CrateAccount."',".$LinkCustomerId.",".$SalesmanCode.",'Insert'");
        return response()->json($insertOrderDetails);
    }
    public function selectCustomerMultiAddress(Request $request)
    {
        $custCode = $request->get('customerCode');
        $zero = 0;
        if (config('app.IS_API_BASED')) {
            $countAddress = $this->apiSelectCustomerMultiAddress([
                'custCode' => $custCode,
                'zero' => $zero,
            ]);
        } else {
            $countAddress = DB::connection('sqlsrv3')
                ->select("EXEC spCrudDeliveryAddress ".$zero.",'00','00','000','000','000',00,00,'00','" . $custCode . "',00,'Select'");
        }

        return response()->json($countAddress);
    }
    public function selectCustomerMultiAddressconfirm(Request $request)
    {
        $CustCode= $request->get('customerCode');
        $OrderId = $request->get('OrderId');
        $zero = 0;
        if (config('app.IS_API_BASED')) {
            $output = $this->apiSelectCustomerMultiAddressconfirm([
                'CustomerCode' => $CustCode,
                'OrderId' => $OrderId,
                'zero' => $zero,
            ]);
        } else {
            $returnAddress = DB::connection('sqlsrv3')
                ->select("EXEC spCrudDeliveryAddress ".$zero.",'00','00','000','000','000',00,00,'00','".$CustCode."',00,'Select'");

            $returnselected = DB::connection('sqlsrv3')
                ->select("EXEC spGetSelectedAddressForMultiDeliveries ".$OrderId);

            $routes = DB::connection('sqlsrv3')
                ->select("select * from tblRoutes order by Route");

            $output["addresses"] = $returnAddress;
            $output["selectedaddress"] = $returnselected;
            $output["routes"] = $routes;
        }

        return response()->json($output);
    }
    public function submitchangeddeliveryaddress(Request $request){
        $delvdata = $request->get('delvdata');
        $OrderId = $request->get('OrderId');
        $delvdataxml = $this->toxml($delvdata, "xml", array("result"));
        $returndata = DB::connection('sqlsrv3')
            ->select("EXEC spXMLUpdateOrderDeliveryaddress '".$delvdataxml."',".$OrderId);
        return response()->json($returndata);


    }
    public function countomerSingleAddress(Request $request)
    {
        $CustCode= $request->get('customerCode');

        $zero = 0;
        $countAddress = DB::connection('sqlsrv3')
            ->select("EXEC spCrudDeliveryAddress ".$zero.",'00','00','000','000','000',00,00,'00','".$CustCode."',00,'Select'");

        return response()->json($countAddress);
    }
    public function countAddress(Request $request)
    {
        $CustCode= $request->get('customerCode');

        $zero = 0;
        $countAddress = DB::connection('sqlsrv3')
            ->select("EXEC spCrudDeliveryAddress ".$zero.",'00','00','000','000','000',00,00,'00','".$CustCode."',00,'Count'");
        return response()->json($countAddress);
    }
    public function spCreateNewtblCustomerDeliveryAddress(Request $request)
    {
        $CustCode= $request->get('customerCode');
        $address1= $request->get('address1');
        $address2= $request->get('address2');
        $address3= $request->get('address3');
        $address4= $request->get('address4');
        $address5= $request->get('address5');
        $routeId= $request->get('routeId');
        $routeName= $request->get('routeName');
        $SalesPerson = $request->get('SalesPerson');
        $salesName = $request->get('SalesPersonName');
        if (strlen($routeId) < 1){
            $routeId = null;
        }

        $CustomerId = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$CustCode)->get();
        $LinkCustomerId = $CustomerId[0]->CustomerId;
        $returnAdressID = DB::connection('sqlsrv3')
            ->select("EXEC spCreateNewtblCustomerDeliveryAddress ".$LinkCustomerId.",'".$address1."','".$address2."','".$address3."','".$address4."','".$address5."',".$routeId.",".$SalesPerson);
        $output['ID']= $returnAdressID[0]->ID;
        $output['address1']= $address1;
        $output['address2']= $address2;
        $output['address3']= $address3;
        $output['address4']= $address4;
        $output['address5']= $address5;
        $output['routeId']= $routeId;
        $output['routeName']= $routeName;
        $output['salesName']= $salesName;
        return $output;
    }
    public function getLastInsertedDate()
    {
        $getLastInserted= DB::connection('sqlsrv3')
            ->select("Select * from viewGetLastInsertedOrderIdAndDeliveryDate");
        return response()->json($getLastInserted);
    }
    public function getProductStockOnHand(Request $request)
    {
        $productCode= $request->get('productCode');
        $userid  = Auth::user()->UserID;
        $GetProductStockOnHand= DB::connection('sqlsrv3')
            ->select("EXEC spGetProductStockOnHand '".$productCode."',".$userid);
        return response()->json($GetProductStockOnHand);
    }
    public function selectAddressFromMultiAddressDeliveruyAddressId(Request $request)
    {
        $CustCode= $request->get('CustomerCode');
        $DeliveryAddressIId= $request->get('DeliveryAddressIId');
        $getAddress= DB::connection('sqlsrv3')
            ->select("EXEC spGetDeliveryAddressWithRouteAndUsers '".$CustCode."',".$DeliveryAddressIId);
        return response()->json($getAddress);
    }
    public function splitorders(Request $request)
    {
        $orderid= $request->get('orderID');
        $returndata = DB::connection('sqlsrv3')
            ->select("EXEC spGetProductForBackOrder ".$orderid);
        return response()->json($returndata);
    }
    public function splitordersmake(Request $request)
    {
        $backorder = $request->get('backorder');
        $orderid= $request->get('orderID');
        $userid  = Auth::user()->UserID;
        $username  = Auth::user()->UserName;

        $backorderxml = $this->toxml($backorder, "xml", array("result"));
       // $returndata = DB::connection('sqlsrv3')
        //    ->select("EXEC spXMLSplitOrder '".$backorderxml."','".$username."',".$userid.",".$orderid);

        $returndata= DB::connection('sqlsrv4')
            ->select("Exec spXMLSplitOrder ?,?,?,?",
                array($backorderxml,$username,$userid,$orderid));
  //      dd($returndata);
//dd( $returndata[0]->Result);
        $outPut['Result'] = $returndata[0]->Result;
        return $outPut;
    }
    public function postOrderDetailsAsJsonArray(Request $request)
    {

        //$CustomerCode= $request->get('CustomerCode');
        $OrderId = $request->get('OrderId');
        $orderDetails = $request->get('orderDetails');
        $exclusive = $request->get('exclusive');
        $UserID = Auth::user()->UserID;
        $bollean = true;

        $host = "Browser";
        $result = count($orderDetails);

        if($result > 0) {
            foreach ($orderDetails as $value) {
                if (strlen($value['productCode']) > 0 && strlen($value['qty']) > 0 && strlen($value['price']) > 0) {

                    if (strlen($value['orderDetailID']) < 1) {
                        $value['orderDetailID'] = 0;
                        if (strlen($value['prodDisc']) < 1) {
                            $value['prodDisc'] = 0;
                        }
                        if (trim(strlen($value['unitCount'])) < 1)
                        {
                            $unitCount =0;
                        }else{
                            $unitCount = $value['unitCount'];
                        }
                        $insertOrderDetails = DB::connection('sqlsrv3')
                            ->statement("EXEC spCRUDOrderDetails " . $OrderId . "," . $value['orderDetailID'] . ",'" . $value['customerCode'] . "','" . $value['productCode'] . "'," . $value['qty'] . ","
                                . $value['qty'] . "," . $value['qty'] . "," . $value['price'] . "," . $value['prodDisc'] . ",'" . $value['comment'] . "'," . $UserID . "," .$unitCount.",'Insert',".$value['warehouse']);

                        //dd($insertOrderDetails);
                        if (!$insertOrderDetails) {
                            break;
                        }

                    } else {
                        if (trim(strlen($value['unitCount'])) < 1)
                        {
                            $unitCount =0;
                        }else{
                            $unitCount = $value['unitCount'];
                        }
                        $insertOrderDetails = DB::connection('sqlsrv3')
                            ->statement("EXEC spCRUDOrderDetails " . $OrderId . "," . $value['orderDetailID'] . ",'" . $value['customerCode'] . "','" . $value['productCode'] . "'," . $value['qty'] . ","
                                . $value['qty'] . "," . $value['qty'] . "," . $value['price'] . "," . $value['prodDisc'] . ",'" . $value['comment'] . "'," . $UserID . ",".$unitCount.",'Update',".$value['warehouse']);

                        if (!$insertOrderDetails) {
                            break;
                        }

                    }

                }
            }

        }
        //Check if all lines has been inserted correctly



        $sumCheckFromDB= DB::connection('sqlsrv3')
            ->select("Exec spCalculateVatExc ".$OrderId);

        //
        $difference = (round(floatval($exclusive),2) - round(floatval($sumCheckFromDB[0]->calcExVat),2));
        // print_r(round(floatval($sumCheckFromDB[0]->calcExVat),2));


        if( $difference > 0.5  )
        {

            $outPut['OrderId'] = 'Error';
            (new DimsCommon())->clearAllUserLocks();
            return $outPut;

        }else{
            $outPut['OrderId'] = $OrderId;
            //if conf split is true

            if(env('APP_SPIT') == 'TRUE'){
                $arrayOrderSplits= DB::connection('sqlsrv3')->select("Exec spGetProductForBackOrder ".$OrderId);
                //dd(count($arrayOrderSplits));
                if( count($arrayOrderSplits) > 0 )
                {
                    $outPut['split'] = $arrayOrderSplits;
                }
                else{
                    $outPut['split']='No Split';
                }


            }else
            {
                $outPut['split']='No Split';
            }

            $arrayOrderSplits= DB::connection('sqlsrv3')->select("Exec spGetProductForBackOrder ".$OrderId);
            //$outPut['split'] = $arrayOrderSplits;
            (new DimsCommon())->clearAllUserLocks();
            return $outPut;
        }

    }
    public function postOrderDetailsAsJsonArrayForOtherTransactions(Request $request)
    {

        //$CustomerCode= $request->get('CustomerCode');
        $OrderId = $request->get('OrderId');
        $orderDetails = $request->get('orderDetails');
        $exclusive = $request->get('exclusive');
        $UserID = Auth::user()->UserID;
        $bollean = true;

        $host = "Browser";
        $result = count($orderDetails);


        if($result > 0) {
            foreach ($orderDetails as $value) {
                if (strlen($value['productCode']) > 0 && strlen($value['qty']) > 0 && strlen($value['price']) > 0) {
                    $dtTo = (new \DateTime($value['dateTo']))->format('Y-m-d') ;
                    $dtFrom = (new \DateTime($value['dateFrom']))->format('Y-m-d') ;
                    if (strlen($value['orderDetailID']) < 1) {
                        $value['orderDetailID'] = 0;
                        if (strlen($value['prodDisc']) < 1) {
                            $value['prodDisc'] = 0;
                        }

                        $insertOrderDetails = DB::connection('sqlsrv3')
                            ->statement("EXEC spCRUDOrderDetailsForOtherTransactions " . $OrderId . "," . $value['orderDetailID'] . ",'" . $value['customerCode'] . "','" . $value['productCode'] . "'," . $value['qty'] . ","
                                . $value['qty'] . "," . $value['qty'] . "," . $value['price'] . "," . $value['prodDisc'] . ",'" . $value['comment'] . "'," . $UserID . ",".$value['prodOPrice'].",'".$dtFrom."','".$dtTo."',".$value['margin'].",'Insert'");


                        if (!$insertOrderDetails) {
                            break;
                        }

                    } else {

                        $insertOrderDetails = DB::connection('sqlsrv3')
                            ->statement("EXEC spCRUDOrderDetailsForOtherTransactions " .$OrderId . "," . $value['orderDetailID'] . ",'" . $value['customerCode'] . "','" . $value['productCode'] . "'," . $value['qty'] . ","
                                . $value['qty'] . "," . $value['qty'] . "," . $value['price'] . "," . $value['prodDisc'] . ",'" . $value['comment'] . "'," . $UserID . ",".$value['prodOPrice'].",'".$dtFrom."','".$dtTo."',".$value['margin'].",'Update'");

                        if (!$insertOrderDetails) {
                            break;
                        }

                    }


                }
            }
        }
        //Check if all lines has been inserted correctly


        $sumCheckFromDB= DB::connection('sqlsrv3')
            ->select("Exec spCalculateVatExcForOtherTrans ".$OrderId);
        $difference = (round(floatval($exclusive),2) - round(floatval($sumCheckFromDB[0]->calcExVat),2));

        /* dd($difference);
         if( $difference > 0.5  )
         {

             $outPut['OrderId'] = 'Error';
             (new DimsCommon())->clearAllUserLocks();
            return $outPut;

         }else{*/
        $outPut['OrderId'] = $OrderId;
        (new DimsCommon())->clearAllUserLocks();
        return $outPut;
        // }

    }

    public function postOrderDetailsAsJsonArrayPOS(Request $request)
    {

        //$CustomerCode= $request->get('CustomerCode');
        $OrderId = $request->get('OrderId');
        $orderDetails = $request->get('orderDetails');
        $exclusive = $request->get('exclusive');
        $UserID = Auth::user()->UserID;
        $bollean = true;

        $host = "Browser";
        $result = count($orderDetails);
        //delete before inserting
        DB::connection('sqlsrv3')->table('tblOrderDetails')
            ->where('OrderId',$OrderId )
            ->delete();
        (new ConsoleManagement())->logMessage(2, 1, 0, 'Deleted All the Lines before doing POS transaction', 0, $OrderId, 0, 0, Auth::user()->UserID,
            0, 0, 0, 0, Auth::user()->UserID, $OrderId, 1, $OrderId, "'" . $host . "'", '0');

        if($result > 0) {
            foreach ($orderDetails as $value) {
                if (strlen($value['productCode']) > 0 && strlen($value['qty']) > 0 && strlen($value['price']) > 0) {

                    if (strlen($value['orderDetailID']) < 1) {
                        $value['orderDetailID'] = 0;
                        if (strlen($value['prodDisc']) < 1) {
                            $value['prodDisc'] = 0;
                        }
                        $insertOrderDetails = DB::connection('sqlsrv3')
                            ->statement("EXEC spCRUDOrderDetails " . $OrderId . "," . $value['orderDetailID'] . ",'" . $value['customerCode'] . "','" . $value['productCode'] . "'," . $value['qty'] . ","
                                . $value['qty'] . "," . $value['qty'] . "," . $value['price'] . "," . $value['prodDisc'] . ",'" . $value['comment'] . "'," . $UserID . ",".$value['unitCount'].",'Insert'");

                        //dd($insertOrderDetails);
                        if (!$insertOrderDetails) {
                            break;
                        }



                    } else {
                        $insertOrderDetails = DB::connection('sqlsrv3')
                            ->statement("EXEC spCRUDOrderDetails " . $OrderId . "," . $value['orderDetailID'] . ",'" . $value['customerCode'] . "','" . $value['productCode'] . "'," . $value['qty'] . ","
                                . $value['qty'] . "," . $value['qty'] . "," . $value['price'] . "," . $value['prodDisc'] . ",'" . $value['comment'] . "'," . $UserID . ",".$value['unitCount'].",'Update'");

                        if (!$insertOrderDetails) {
                            break;
                        }

                    }


                }
            }
        }
        //Check if all lines has been inserted correctly


        $sumCheckFromDB= DB::connection('sqlsrv3')
            ->select("Exec spCalculateVatExc ".$OrderId);
        $difference = (round(floatval($exclusive),2) - round(floatval($sumCheckFromDB[0]->calcExVat),2));

        if( $difference > 0.5  )
        {

            $outPut['OrderId'] = 'Error';
            (new DimsCommon())->clearAllUserLocks();
            return $outPut;

        }else{
            $outPut['OrderId'] = $OrderId;
            (new DimsCommon())->clearAllUserLocks();
            return $outPut;
        }

    }
    public function createbackorderonsplit(Request $request)
    {
        $OrderId = $request->get('orderid');
        $orderDetails = $request->get('productsLines');
        $UserID = Auth::user()->UserID;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $t=time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t.$randomString;
        //dd($orderDetails);
        foreach ($orderDetails as $value) {
            DB::connection('sqlsrv3')
                ->statement("Exec spInsertBackOrderLines ".$OrderId.",".$value['orderdetailid'].",".$value['back'].",".$UserID.",'".$ID."','".$value['code']."'");
        }

        DB::connection('sqlsrv3')
            ->statement("Exec spInsertBackOrderHeader ".$OrderId.",'".$ID."'");
        //dd($ID);

    }

    public function printPickingSlipPerOrder(Request $request)
    {
        $OrderId = $request->get('OrderId');
        $orderDetails = $request->get('orderDetails');
        //  dd($orderDetails);
        return response()->json($orderDetails);
    }
    public function copyOrderToNewOrder(Request $request)
    {

        $currentOrderId= $request->get('OrderId');
        $customerCode= $request->get('customerCode');
        $DeliveryAddress= $request->get('delvAddress');
        if (strlen($DeliveryAddress) < 1)
        {
            $DeliveryAddress = "NULL";
        }
        $orderDate=(new \DateTime())->format('Y-m-d');
        $delvDate=(new \DateTime($request->get('delvDate')))->format('Y-m-d');
        //$delvDate= $request->get('delvDate');
        $delivType = $request->get('orderType');
        $orderNo = $request->get('orderNo');
        $routeId= $request->get('routeId');
        $CustomerId = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$customerCode)->get();
        $getCopyingOrder= DB::connection('sqlsrv3')
            ->select("EXEC spCopyInvoice ".$currentOrderId.",".$CustomerId[0]->CustomerId.",".$DeliveryAddress.",'".$orderDate."','".$delvDate."',".$routeId.",".$delivType.",'".$orderNo."'");
        return response()->json($getCopyingOrder);

    }
    public function insertNewAddress(Request $request)
    {
        $AddressLine1 = $request->get('AddressLine1');
        $AddressLine2 = $request->get('AddressLine2');
        $AddressLine3 = $request->get('AddressLine3');
        $AddressLine4 = $request->get('AddressLine4');
        $AddressLine5 = $request->get('AddressLine5');
        $CustomerCode = $request->get('CustomerCode');
        $insertAddress = 'false';
        if (strlen($CustomerCode) > 0) {
            if (config('app.IS_API_BASED')) {
                if ($AddressLine1 || $AddressLine2 || $AddressLine3 || $AddressLine4 || $AddressLine5) {
                    $insertAddress = $this->apiInsertNewAddress([
                        'Address1' => $AddressLine1,
                        'Address2' => $AddressLine2,
                        'Address3' => $AddressLine3,
                        'Address4' => $AddressLine4,
                        'Address5' => $AddressLine5,
                        'CustomerCode' => $CustomerCode,
                    ]);
                }
            } else {
                $insertAddress = DB::connection('sqlsrv3')
                    ->statement("EXEC spAddNewAddress '".$AddressLine1."','".$AddressLine2."','".$AddressLine3."','".$AddressLine4."','".$AddressLine5."','".$CustomerCode."'");
            }
        }

        return response()->json($insertAddress);
    }
    public function getCustomerOrderId(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $statement = "Customer";
        $getOrderIds= DB::connection('sqlsrv3')
            ->select("EXEC spGetCustomerOrderIds '".$customerCode."','".$statement."'");
        return response()->json($getOrderIds);
    }
    public function getAllOrderIDs()
    {
        $customerCode ="ALL";
        $statement = "All";

        $getOrderIds= DB::connection('sqlsrv3')
            ->select("EXEC spGetCustomerOrderIds '".$customerCode."','".$statement."'");

        return response()->json($getOrderIds);
    }
    public function copyOrdersToCustomers(Request $request)
    {
        $productsObject = $request->get('productsObject');
        $theCustCode_ = $request->get('theCustCode_');
        // dd($theCustCode_);
        $delvDate_ = (new \DateTime($request->get('delvDate_')))->format('Y-m-d');
        $orderDate = (new \DateTime($request->get('orderDate')))->format('Y-m-d');
        $delAddress_ = $request->get('delAddress_');
        $delAddressText_ = $request->get('delAddressText_');
        $orderNumber_ = $request->get('orderNumber_');
        $delType_ = $request->get('delType_');
        $discount = $request->get('discount');
        $unitCount = $request->get('unitCount');
        $statement = "Insert";
        $OrderDate = (new \DateTime($request->get('orderDate')))->format('Y-m-d');
        $newarray = explode("|", $delAddressText_);
        //dd($newarray[1]);
        $address1 = $newarray[1];
        $address2 = $newarray[2];
        $address3 = $newarray[3];
        $address4 = $newarray[4];
        $address5 = $newarray[5];

        if (strlen($address1) < 1)
        {
            $address1 = "NULL";
        }
        if (strlen($address2) < 1)
        {
            $address2 = "NULL";
        }
        if (strlen($address3) < 1)
        {
            $address3 = "NULL";
        }
        if (strlen($address4) < 1)
        {
            $address4 = "NULL";
        }
        if (strlen($address5) < 1)
        {
            $address5 = "NULL";
        }
        $userID =  Auth::user()->UserID;
        if($theCustCode_ !=null){
            $returnID = DB::connection('sqlsrv3')->select("EXEC spCRUDOrderHeaders 0,'".$theCustCode_."',".$delAddress_.
                ",'".$orderDate."','".$delvDate_."',".$delType_.",'".$orderNumber_."',0,'".$statement.
                "','".$address1."','".$address2."','".$address3."','".$address4."','".$address5."','0',".$userID.",0,".$discount);

            if (!empty($returnID))
            {
                //insert into details ID
                foreach ($productsObject as $value)
                {

                    $OrderDetailId =0;
                    //$CustomerId = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode',$theCustCode_)->get();
                    // $productID = DB::connection('sqlsrv3')->table('tblProducts')->select('ProductId')->where('PastelCode',$value['code'])->get();
                    $Qty = $value['qty'];
                    $returnPrice = DB::connection('sqlsrv3')
                        ->select('exec spCustomerPriceLookUp ?,?,?,?,?',
                            array($delvDate_,$value['code'],$theCustCode_,-1,$userID)
                        );

                    $Price = 0;
                    $LineDisc = 0;
                    if(!empty($returnPrice))
                    {
                        $Price = $returnPrice[0]->Price;
                    }
                    $insertOrderDetails = DB::connection('sqlsrv3')
                        ->select("EXEC spCRUDOrderDetails ".$returnID[0]->ID.",".$OrderDetailId .",'".$theCustCode_."','".$value['code']."',
            ".$Qty.",".$Qty.",".$Qty.",".$Price.",".$LineDisc.",'".$value['comment']."',".$userID.",".$unitCount.",'Insert'");
                }
            }
            $outPut['orderId'] = $returnID[0]->ID;
            $outPut['custCode'] = $theCustCode_;
            return $outPut;
        }else{
            $outPut['custCode'] = "Starting";
            $outPut['orderId'] = "******";
            return $outPut;
        }

    }
    public function getordertorelease(Request $request)
    {
        /*$orders = DB::connection('sqlsrv3')
            ->select("EXEC spGetListOfOrdersToRelease");*/
        return view('dims/releaseorders');
    }
    public function getorderheadertorelease(Request $request)
    {
        $orders = DB::connection('sqlsrv3')
            ->select("EXEC spGetListOfOrdersToRelease");
        return response()->json($orders);
    }
    public function getorderlineslist($orderid)
    {
        $orders = DB::connection('sqlsrv3')
            ->select("EXEC spGetListOfLinesToRelease '$orderid'");
        return response()->json($orders);

    }
    public function getbelowgp()
    {
        return view('dims/belowgp');
    }
    public function getbelowgpheader(Request $request)
    {
        $orders = DB::connection('sqlsrv3')
            ->select("EXEC spCustomerWrongGP");
        return response()->json($orders);
    }
    public function getbelowgplines($orderid)
    {
        $orders = DB::connection('sqlsrv3')
            ->select("EXEC spCustomerWrongGPLines '$orderid'");
        return response()->json($orders);

    }
    public function postreleaseorder(Request $request)
    {
        $orderid  =  $request->get("orderids");
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $updateErrors = DB::connection('sqlsrv3')
            ->select("EXEC spReleaseOrder ".$orderid.",'".$userName."',".$userid);
        return response()->json($updateErrors);
        // return view('dims/releaseorders');
    }
    public function postordergpproblem(Request $request)
    {
        $orderid  =  $request->get("orderids");
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $updateErrors = DB::connection('sqlsrv3')
            ->select("EXEC spReleaseOrder ".$orderid.",'".$userName."',".$userid);
        return response()->json($updateErrors);
        // return view('dims/releaseorders');
    }
    public function getAllProductsAndCosts()
    {
        $queries =DB::connection('sqlsrv3')->table("viewActiveProductWithVat")->get();
        return response()->json($queries);
    }
    public function getProductCodes()
    {
        $queries =DB::connection('sqlsrv3')->table("viewActiveProductWithVat")->select('PastelCode')->get();
        return response()->json($queries);
    }

    public function generatePDFForOrders(Request $request)
    {
        $array = $request->get('orderLinesOnTheFly');
        $totalIncPreview = $request->get('totalInc');
        $custDescription = $request->get('custDescription');
        $orderId = $request->get('orderId');
        $view = View::make('dims/email_order_on_the_fly', [
            'message' => $array,'total'=>$totalIncPreview,'custName'=>$custDescription
        ]);
        $html = $view->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $output = $pdf->output();
        $time = time();

        Storage::put('/app/pdfs/sales_o'.$orderId."_".$time.'.pdf', $output);
        $file = storage_path('/app/app/pdfs/sales_o'.$orderId."_".$time.'.pdf');

        return $file;
    }
    public function adjustTheDispatchQtyOnPickingOrder(Request $request)
    {
        $prodLines = $request->get('prodLines');
        $message = $request->get('message');
        $orderId = $request->get('orderId');
        $orderNo = $request->get('orderNo');
        $awaiting = 0;
        $orderDetailID = 0;
        $userID = Auth::user()->UserID;

        $LineDisc = 0;
        //dd($prodLines);

        foreach ($prodLines as $value)
        {
            if(strlen($value['productCode']) > 0 && strlen($value['qty']) > 0 && strlen($value['price']) > 0){
                if (strlen($value['orderDetailID']) <1)
                {
                    $value['orderDetailID'] = 0;
                }
                $strComment = str_replace("'", "''", $value['comment']);

                $insertOrUpdateOrderDetails = DB::connection('sqlsrv3')
                    ->statement("EXEC spCRUDOrderDetails ".$orderId.",".$value['orderDetailID'] .",'".$value['customerCode']."','".$value['productCode']."',".$value['qty'].",".$value['qty'].",".$value['qty'].",".$value['price'].",".$LineDisc.",'".$strComment."',".$userID.",".$value['unitCount'].",'DispatchAdjustment'");
                //Management consoles
            }
        }
        $strComment = str_replace("'", "''", $message);
        (new DimsCommon())->simpleOrderUpdate($orderId,$strComment,$orderNo,0);
        (new DimsCommon())->unLockOrder($orderId);

    }
    public function printInvoiceFromPickingFormAdjustment(Request $request)
    {
        $prodLines = $request->get('prodLines');
        $message = $request->get('message');
        $orderId = $request->get('orderId');
        $orderNo = $request->get('orderNo');
        $awaiting = $request->get('awaiting');

        $orderDetailID = 0;

        $LineDisc = 0;
        $counter = 0;
        $userID = Auth::user()->UserID;

        foreach ($prodLines as $value)
        {
            if(strlen($value['productCode']) > 0 && strlen($value['qty']) > 0 && strlen($value['price']) > 0){
                if (strlen($value['orderDetailID']) <1)
                {
                    $value['orderDetailID'] = 0;
                }
                $insertOrUpdateOrderDetails = DB::connection('sqlsrv3')
                    ->statement("EXEC spCRUDOrderDetails ".$orderId.",".$value['orderDetailID'] .",'".$value['customerCode']."','".$value['productCode']."',".$value['qty'].",".$value['qty'].",".$value['qty'].",".$value['price'].",".$LineDisc.",'".$value['comment']."',".$userID.",".$value['unitCount'].",'DispatchAdjustment'");
                $counter++;
            }
        }
        (new DimsCommon())->simpleOrderUpdate($orderId,$message,$orderNo,0);
        $GetOrderDetails= DB::connection('sqlsrv3')
            ->select("EXEC spBackOrderLines ".$orderId);

        (new DimsCommon())->unLockOrder($orderId);

        // return response()->json($GetOrderDetails);

        if ($counter > 0)
        {
            $User = Auth::user()->UserID;
            $printerPath = "\\\\".gethostname();
            $PrintDeliveryNote = '0';


            $returnStatement = DB::connection('sqlsrv3')
                ->statement("EXEC spAssignInvoiceNumber '".$orderId."',". $User);

            $return = DB::connection('sqlsrv3')->table('tblOrders')
                ->select('InvoiceNo')->where('OrderId',$orderId)->get();

            if(strlen($return[0]->InvoiceNo) > 1 )
            {

                DB::connection('sqlsrv3')
                    ->statement("EXEC spInsertIntoPrintedDoc 1,".$orderId.",".$User.",'".$printerPath."',".$PrintDeliveryNote);
                $GetOrderDetails= DB::connection('sqlsrv3')
                    ->select("EXEC spBackOrderLines ".$orderId);

                return response()->json($GetOrderDetails);
            }
            else{
                return "Process failed";//when gerating the invoice number.
            }

        }
    }
    public function createAbackOrder(Request $request)
    {
        $delvDate_ = (new \DateTime())->format('Y-m-d');
        $orderDate = (new \DateTime())->format('Y-m-d');
        $User = Auth::user()->UserID;
        $orderId = $request->get('orderId');

        $GetOrderDetails= DB::connection('sqlsrv3')
            ->select("EXEC spCreateABackOrder '".$delvDate_."','".$orderDate."',".$User.",".$orderId);
        return response()->json($GetOrderDetails);
    }
    public function productsOnOrder(Request $request)
    {
        $productCode = $request->get('productCode');
        $customerCode = $request->get('customerCode');
        $userid = Auth::user()->UserID;

        $customerCode = str_replace("'", "''", $customerCode);
        $GetProductsOrder= DB::connection('sqlsrv3')->select("EXEC spOnOrder '".$productCode."','".$customerCode."',".$userid);
        // $output['recordsTotal'] = count($GetProductsOrder);
        // $output['data'] = $GetProductsOrder;
        // $output['recordsFiltered'] = count($GetProductsOrder);

        // $output['draw'] = intval($request->input('draw'));

        return response()->json($GetProductsOrder);
    }

    public function deleteOrderLine(Request $request)
    {
        $OrderId = $request->get('OrderId');
        $result= DB::connection('sqlsrv3')->select("EXEC spDeleteOrderLine ?",array($OrderId));

        return response()->json($result);
    }

    public function deleteOrderLinedetails(Request $request)
    {
        $OrderId = $request->get('OrderId');
        if (config('app.IS_API_BASED')) {
            $result = $this->apiDeleteOrderLinedetails([
                'OrderId' => $OrderId
            ]);
        } else {
            $userid = Auth::user()->UserID;
            $UserName = Auth::user()->UserName;
            $result = DB::connection('sqlsrv3')->select("EXEC spDeleteOrderLinedetails ?,?,?",array($OrderId,$userid,$UserName));
        }

        return response()->json($result);
    }

    public function productsOnInvoiced(Request $request)
    {
        $productCode = $request->get('productCode');
        $customerCode = $request->get('customerCode');
        $userid = Auth::user()->UserID;
        $customerCode = str_replace("'", "''", $customerCode);
        $GetProductsOrder= DB::connection('sqlsrv3')
            ->select("EXEC spOnInvoiced '".$productCode."','".$customerCode."',".$userid);
        $output['recordsTotal'] = count($GetProductsOrder);
        $output['data'] = $GetProductsOrder;
        $output['recordsFiltered'] = count($GetProductsOrder);

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }
    public function countOnSalesOrder(Request $request)
    {
        $productCode = $request->get('prodCode');
        $sumQtyOrder = DB::connection('sqlsrv3')->select("EXEC spOnCountOnOrder '".$productCode."'");
        return response()->json($sumQtyOrder[0]->Qty);
        //spOnCountOnOrder
    }
    public function changeDeliveryAddressOnNoInvoiceNo(Request $request)
    {
        $customerCode = $request->get('customerCode');
        if (config('app.IS_API_BASED')) {
            $GetOrderDetails = $this->apiChangeDeliveryAddressOnNoInvoiceNo([
                'CustomerCode' => $customerCode
            ]);
        } else {
            $GetOrderDetails = DB::connection('sqlsrv3')
                ->select("EXEC spChangeDeliveryAddressOnNoInvoiceNo '".$customerCode."'");
        }

        return response()->json($GetOrderDetails);
    }
    public function updateAuthHeader(Request $request)
    {
        //orderId
        $orderId = $request->get('orderId');
        $parameter = $request->get('parameter');

        DB::connection('sqlsrv3')->table('tblOrders')
            ->where('OrderId',$orderId )
            ->update(['Authorised' => $parameter]);
        $GetIfAuth= DB::connection('sqlsrv3')->table('tblOrders')->select('Authorised')->where('OrderId',$orderId)->get();
        return response()->json($GetIfAuth);
    }
    public function waitingForInvoiceNo(Request $request)
    {
        $orderId = $request->get('orderID');
        $custCode = $request->get('customerCode');
        $TotalTendered = $request->get('TotalTendered');
        $Change = $request->get('Change');
        $AmountToPost = $request->get('AmountToPost');
        $posPayMentTypeCash = $request->get('posPayMentTypeCash');
        $posPayMentTypeCheque = $request->get('posPayMentTypeCheque');
        $posPayMentTypeCreditCard = $request->get('posPayMentTypeCreditCard');
        $posPayMentTypeAccount = $request->get('posPayMentTypeAccount');
        $invoiceTotalFromTheDoc = $request->get('invoiceTotal');
        if (config('app.IS_API_BASED')) {
            $response = $this->apiWaitingForInvoiceNo([]);
        } else {
            $UserID = Auth::user()->UserID;
            $UserName = Auth::user()->UserName;
            $array = array($posPayMentTypeCash,$posPayMentTypeCheque,$posPayMentTypeCreditCard,$posPayMentTypeAccount);
            $counter = 0;
            $GetProductsOrder= DB::connection('sqlsrv3')
                ->select("EXEC spWaitingInvoiceNo ".$orderId.",".$UserID.",'".$custCode."','".$orderId."',
                    'TestIV',".$invoiceTotalFromTheDoc.",".$posPayMentTypeCreditCard.",
                    ".$posPayMentTypeAccount.",".$posPayMentTypeCash.",".$posPayMentTypeCheque.",".$Change.",'".$UserName."'");
            $response = $GetProductsOrder[0]->results;
        }

        return response()->json($response);
    }
    public function AssignInvoiceNumber(Request $request){
        $orderId = $request->get('orderID');
        if (config('app.IS_API_BASED')) {
            $this->apiAssignInvoiceNumber([
                'OrderId' => $orderId
            ]);
        } else {
            $UserID = Auth::user()->UserID;
            $spAssign = DB::connection('sqlsrv3')
                ->select("EXEC spAssignInvoiceNumberPOS ".$orderId.",".$UserID);
        }
    }
    public function checkifInvoiced(Request $request)
    {
        $orderId = $request->get('orderID');
        if (config('app.IS_API_BASED')) {
            $response = $this->apiCheckifInvoiced([
                'OrderId' => $orderId
            ]);
        } else {
            $UserID = Auth::user()->UserID;
            $GetProductsOrder = DB::connection('sqlsrv3')
                ->select("EXEC spCheckInvoiced ".$orderId.",".$UserID);
            $response = $GetProductsOrder[0]->results;
        }

        return response()->json($response);
    }
    public function doesExistsRc($rc,$orderId)
    {
        $result = true;
        $receipts = DB::connection('sqlsrv3')->table('tblPOS_TenderLines')->select('ReceiptNumber')->where('OrderId',$orderId)->where('ReceiptNumber',$rc)->first();
        if (count($receipts) > 0)
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }
    public function toProcessPosTenderLines(Request $request)
    {
        $orderId = $request->get('orderID');
        $invoiceNo = $request->get('invoiceNo');
        $custCode = $request->get('customerCode');
        $TotalTendered = $request->get('TotalTendered');
        $Change = $request->get('Change');
        $AmountToPost = $request->get('AmountToPost');


    }
    //To be removed
    public function pointOfSale()
    {



        return view('dims/point_of_sale');

    }
    public function posCashFloat(Request $request)
    {
        $cashFloat =  DB::connection('sqlsrv3')->table('tblPOS_CashFloat')->select('CashFloatDate', 'CashFloatAmount')->orderBy('CashFloatDate', 'desc')
            ->get();
        $output['recordsTotal'] = count($cashFloat);
        $output['data'] = $cashFloat;
        $output['recordsFiltered'] = count($cashFloat);

        $output['draw'] = intval($request->input('draw'));
        return $output;
    }
    public function postPOSfloat(Request $request)
    {
        $floatDate = $request->get('floatDate');
        $floatAmount = $request->get('floatAmount');
        $outPut['floatDate'] = $floatDate;
        $outPut['floatAmount'] = $floatAmount;
        $GetTenderType= DB::connection('sqlsrv3')->table('tblPOS_CashFloat')->select('CashFloatDate')->where('CashFloatDate',(new \DateTime($floatDate))->format('Y-m-d H:m:s'))->get();

        if(count($GetTenderType) < 1){

            DB::connection('sqlsrv3')->table('tblPOS_CashFloat')->insert(
                ['CashFloatDate' => (new \DateTime($floatDate))->format('Y-m-d H:m:s'), 'CashFloatAmount' => $floatAmount]);

            return 'Inserted';
        }
        else{
            // dd(count($GetTenderType));
            return $outPut;
        }

    }
    public function deletePOSfloat(Request $request)
    {
        $floatDate = $request->get('floatDate');
        DB::connection('sqlsrv3')->table('tblPOS_CashFloat')->where('CashFloatDate', $floatDate)->delete();
    }
    public function updatePosRoute(Request $request)
    {
        //POS ROUTE NEEDS TO BE COLLECTION
        $orderId = $request->get('orderId');
        $getCollectionRoute= DB::connection('sqlsrv3')->table('tblRoutes')->select('Route','Routeid')->where('Route','COLLECTION')->get();
        DB::connection('sqlsrv3')->table('tblOrders')
            ->where('OrderId', $orderId)
            ->update(['RouteId' => $getCollectionRoute[0]->Routeid]);
        return response()->json($getCollectionRoute[0]->Routeid);

    }
    public function updateCContactsOnOrder(Request $request)
    {
        $contactCellOnDispatch = trim($request->get('contactCellOnDispatch'));
        $contactPersonOnDispatch = trim($request->get('contactPersonOnDispatch'));
        $CustomerPastelCode = trim($request->get('CustomerPastelCode'));
        $telOnDispatch = trim($request->get('telOnDispatch'));
        $contactCellTel = $telOnDispatch." ".$contactCellOnDispatch;

        if (config('app.IS_API_BASED')) {
            $this->apiUpdateCContactsOnOrder([
                'CellNo' => $contactCellTel,
                'ContactPerson' => $contactPersonOnDispatch,
                'TelNo' => $contactCellTel,
                'CustomerCode' => $CustomerPastelCode,
            ]);
        } else {
            DB::connection('sqlsrv3')->table('tblCustomers')
                ->where('CustomerPastelCode',$CustomerPastelCode )
                ->update(['BuyerTelephone' => $contactCellTel,'BuyerContact'=>$contactPersonOnDispatch]);
        }

        //to be revisited
        return response()->json(1);
    }
    public function treatAsQuote(Request $request)
    {
        $orderId = $request->get('orderId');
        $isQuote = $request->get('isQuote');
        $dateFrom = (new \DateTime())->format('Y-m-d H:i:s');
        if (config('app.IS_API_BASED')) {
            $this->apiTreatAsQuote([
                'OrderId' => $orderId,
                'isTreatAsQuotation' => $isQuote,
            ]);
        } else {
            $Message = "";
            $userName = Auth::user()->UserName;
            DB::connection('sqlsrv4')->statement('exec spUpdateQuote ?,?',array($orderId,$isQuote));
            if($isQuote == "1") {
                $Message="The Order has been changed to be a quote by ".$userName;
            } else {
                $Message="The Quotation has been changed to be a Sales Orders by ".$userName;
            }
            $userId = Auth::user()->UserID;
            DB::connection('sqlsrv3')->table('tblManagementConsol')->insert([
                'OrderId' => $orderId,
                'UserId' => $userId,
                'ConsoleTypeId' => 2,
                'Importance' => 1,
                'dtm' => $dateFrom,
                'LoggedBy' => $userName,
                'UserId' => $userId,
                'Message'=>$Message
            ]);
        }
    }

    public function markitawaitingstock(Request $request)
    {
        $orderId = $request->get('orderId');
        $isQuote = $request->get('isQuote');
        $dateFrom = (new \DateTime())->format('Y-m-d H:i:s');
        if (config('app.IS_API_BASED')) {
            $response = $this->apiMarkitawaitingstock([
                'OrderId' => $orderId,
                'isAwaitingStock' => $isQuote,
            ]);

            return response()->json($response);
        } else {
            $Message = "";
            $userName =   Auth::user()->UserName;
            DB::connection('sqlsrv4')->table('tblOrders')
                ->where('OrderId',$orderId )
                ->update(['AwaitingStock' => $isQuote]);
            if($isQuote == "1") {
                $Message="The Order has been changed to Awaiting Stock by ".$userName;
            } else {
                $Message="The Order has been changed to NOT Awaiting Stock ".$userName;
            }
            $userId = Auth::user()->UserID;
            DB::connection('sqlsrv3')->table('tblManagementConsol')->insert([
                'OrderId' => $orderId,
                'UserId' => $userId,
                'ConsoleTypeId' => 2,
                'Importance' => 1,
                'dtm' => $dateFrom,
                'LoggedBy' => $userName,
                'UserId' => $userId,
                'Message'=>$Message
            ]);
        }
    }
    public function viewordersonawaiting($orderid){

        $getRouteProducts = DB::connection('sqlsrv4')
            ->select("EXEC spTabletLoading " . $orderid);
        return view('dims/awaitingdialog')->with('orderId', $orderid)
            ->with('products', $getRouteProducts);
    }
    public function removeorderfromawaitingstock(Request $request){
        //$orderid

        $userId =   Auth::user()->UserID;
        $userName =   Auth::user()->UserName;
        $OrderId =  $request->get("OrderId");
        $dateFrom = (new \DateTime($request->get("deliverydate") ))->format('Y-m-d');
        DB::connection('sqlsrv3')->table('tblOrders')
            ->where('OrderId', $OrderId)
            ->update(['DeliveryDate' =>$dateFrom,'AwaitingStock'=>0]);

        DB::connection('sqlsrv3')->table('tblManagementConsol')->insert(
            ['OrderId' => $OrderId, 'UserId' => $userId,'ConsoleTypeId'=>2,'Importance'=> 1 ,'dtm'=>$dateFrom,'LoggedBy'=>$userName,'UserId'=>$userId,
                'Message'=>"Removed the order From Awaiting Stock " ]
        );

        echo  "Done";
    }
    private static function getTabs($tabcount)
    {
        $tabs = '';
        for($i = 0; $i < $tabcount; $i++)
        {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = Array(), $tabcount = 0)
    {
        $result = '';
        $tabs = self::getTabs($tabcount);
        foreach($arr as $key => $val)
        {
            $element = isset($elements[0]) ? $elements[0] : $key;
            $result .= $tabs;
            $result .= "<" . $element . ">";
            if(!is_array($val))
                $result .= $val;
            else
            {
                $result .= "\r\n";
                $result .= self::asxml($val, array_slice($elements, 1, true), $tabcount+1);
                $result .= $tabs;
            }
            $result .= "</" . $element . ">\r\n";
        }
        return $result;
    }

    public static function toxml($arr, $root = "xml", $elements = Array())
    {
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }

}
