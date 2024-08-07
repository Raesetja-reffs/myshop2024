<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;
class OnlineOrders extends Controller
{
    public function remoteorders()
    {
        $this->authorizeCompanyPermission('isallowecommerce');
        $myMarkerOrders=$this->mymarketGetSales();
        return view('dims/remote_orders')->with('MyMarket',$myMarkerOrders);
    }
    public function getFreshOrderHeaders()
    {
        $orderheaders= DB::connection('linxbriefcase')
            ->select("Select * from  viewFreshOrderHeaders  order by OrderDate,CustomerStoreName");
        return response()->json($orderheaders);
    }
    public function getOrderLines($ID)
    {
        $orderlines= DB::connection('linxbriefcase')
            ->select("Select * from  viewOrderLines where ID='$ID'  order by strDesc");
        return response()->json($orderlines);
    }
    public function Xmlcommitremoteorder(Request $request)
    {

        $orderDetails = $request->get('value');
        $custCode = $request->get('custCode');
        $orderdate = $request->get('orderdate');
        $deldate = $request->get('deldate');
        $ordernumber = $request->get('ordernumber');
        $username = $request->get('username');
        $notes = $request->get('notes');
        $addressID = $request->get('addressID');
        $orderdiscount = $request->get('orderdiscount');
        $orderdiscount = $request->get('orderdiscount');
        $orderdiscount = $request->get('orderdiscount');
        $orderdiscount = $request->get('orderdiscount');
        $orderdiscount = $request->get('orderdiscount');
        $orderdiscount = $request->get('orderdiscount');
        $userid = Auth::user()->UserID;

        $orderDetailsxml = $this->toxml($orderDetails, "xml", array("result"));

        $getcommitorder = DB::connection('sqlsrv3')
            ->select('exec spXmlCommitOnlineOrder ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                array($orderDetailsxml,$custCode,$orderdate,$deldate,$ordernumber,$username,$notes,$addressID,$userid,$orderdiscount)
            );



      /* $getcommitorder = DB::connection('linxbriefcase')
           ->select("Select DIMSOrderDetailID,strPartNumber,Price,Quantity,'SUCCESS' as Result  from  OrderLines where ID = '1575456536r9ZkgHxmeR'");*/
       // $getcommitorder['Result']="SUCCESS";
        //$outPut['result'] = $getcommitorder;
        return response()->json($getcommitorder);

    }
    public function outstandingorders()
    {
        return view('dims/outstandingorders');
    }
    public function getFreshOrderHeadersOutstanding()
    {
        $orderheaders= DB::connection('linxbriefcase')
            ->select("Select * from  viewFreshOrderHeadersOutstanding order by OrderDate,CustomerStoreName");
        return response()->json($orderheaders);
    }
    public function updateOnlineLinesAndHeaders(Request $request)
    {
        $Orderid = $request->get('Orderid');
        $ID = $request->get('ID');
        $orderlines = DB::connection('sqlsrv3')
            ->select("Select PastelCode,OrderDetailId from  tblOrderDetails inner join viewtblProducts on viewtblProducts.ProductId = tblOrderdetails.ProductId where Orderid = $Orderid ");

        foreach ($orderlines as $val)
        {
            DB::connection('linxbriefcase')->table('OrderLines')->where('ID', $ID)->where('strPartNumber',$val->PastelCode)->update(['DIMSOrderDetailID' => $val->OrderDetailId]);
        }
        DB::connection('linxbriefcase')->table('OrderHeaders')->where('ID', $ID)->update(['DimsOrderID' =>  $Orderid ,'ExportedToDims'=>1]);
        $returnedOrderlines= DB::connection('linxbriefcase')
            ->select("Select DIMSOrderDetailID,strPartNumber,Price,Quantity  from  OrderLines where ID = '$ID'");

        $token = $request->get('token');
        $returnExternalOrderLines = DB::connection('linxbriefcase')
            ->select("EXEC spGetExternalOrders '$ID'" );

        $cat = array();
        $priceInfo = array();
        $priceInfosummary = array();
        $prods = array();
        $main = array();
        $jObject = array();
        $count = 0;
        $id = '';

        foreach ($returnExternalOrderLines as $value)
        {
            if ($count < 1){
                $id = $value->externalOrderId;
                $count++;
            }
            $priceInfo['ean'] = $value->BarCode;
            $priceInfo['quantity'] = (int)$value->Quantity;
            $main[] =$priceInfo;
        }


        $priceInfosummary['transactionId'] = $id;
        $priceInfosummary['lineItems'] = $main;


        return response()->json($priceInfosummary);

    }
    public function deleteRemoteOrder(Request $request)
    {
        $ID = $request->get('ID');
        $userName = Auth::user()->UserName;
        $returnmet = DB::connection('linxbriefcase')->table('OrderHeaders')->where('ID', $ID)->update(['DimsOrderID' =>  -9999 ,'ExportedToDims'=>1]);

        $getHeader = DB::connection('linxbriefcase')
            ->select("Select RepEmail,DIMSUser,DeliveryDate,CustomerCode from OrderHeaders
                        left outer join Users on Users.UserName = OrderHeaders.UserName
                        where ID='".$ID."'");

        $getRouteProducts =DB::connection('sqlsrv3')
            ->statement('exec spDeletedRemoteOrder ?,?,?,?,?,?',
                array($ID,$userName,$getHeader[0]->RepEmail,$getHeader[0]->CustomerCode,$getHeader[0]->DeliveryDate,$getHeader[0]->DIMSUser)
            );

        return $returnmet;
    }
    public function onlineOrderHistory($date1,$date2)
    {
        $orderheaders= DB::connection('linxbriefcase')
            ->select("Select * from  viewFreshOrderHeadersOutstanding order by OrderDate,CustomerStoreName");
        return response()->json($orderheaders);
    }
    public function testAPI(Request $request)
    {
        $lists = $request->get('lists');
        $ID = $request->get('ID');
        $lists = $request->get('lists');

        $curl = curl_init();

        if(env('APP_HAS_UNILEVER') == "YES" ){

            curl_setopt_array($curl, array(
               // CURLOPT_URL => "http://stage-sifu.ufs.com:80/ecom/order/feedback/",
                CURLOPT_URL => "https://sifu.unileversolutions.com/ecom/order/feedback/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>json_encode($lists)/*'{"transactionId":"6b223ffe-a42a-479f-9833-ef9d83db2eb9","liteApiEnabled":false,"lineItems":[{"ean":"6001087307604","quantity":1}]}'*/,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    //"x-api-key: 11mG1mr1JwsOXM5DpxKZJGXSkJK7TrmuoyPO0ns5"
                    "x-api-key: 11mG1mr1JwsOXM5DpRoDJGXSkJK7TrmuoyPO0ns5"

                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;
       }
        return view('dims/testblade');
    }
    public function getNewDealToAuth($ID)
    {
        $dealToAuth= DB::connection('linxbriefcase')
            ->select("Exec spGetDealToAuth '$ID'");
        return view('dims/deal_to_auth')->with('dealtoauth',$dealToAuth);
    }
    public function postauthdeal(Request $request)
    {
        $dealToPost = $request->get('griddetails');
        $customerCode = $request->get('customerCode');
        $minDate = $request->get('minDate');
        $maxDate = $request->get('maxDate');
        $ID = $request->get('ID');
        $repemail = $request->get('repemail');
        $userName = Auth::user()->UserName;
        $userId = Auth::user()->UserID;
        $detailsLinesxml = $this->toxml($dealToPost, "xml", array("result"));

        //dd("exec spXmlCommitOnlineDeal ". $detailsLinesxml.','.$customerCode.','.$minDate.','.$maxDate.','.$userName.','.$userId.','.$repemail.','.$ID) ;

        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select('exec spXmlCommitOnlineDeal ?,?,?,?,?,?,?,?',
                array($detailsLinesxml,$customerCode,$minDate,$maxDate,$userName,$userId,$repemail,$ID)
            );

        if (count($GetCustomerSpecail) > 0) {
            foreach ($dealToPost as $value) {
                DB::connection('linxbriefcase')->table('DealsLines')->where('ID', $ID)->where('strPartNumber', $value['theProductCode_'])->update(['ExportedToDims' => 1]);
            }

            DB::connection('linxbriefcase')->statement("UPDATE OrderHeaders set ExportedToDims = 1 where ID='$ID'");
        }
        return response()->json($GetCustomerSpecail);
    }
    public function orderScreening(){

        $ordSreening= DB::connection('linxbriefcase')
            ->select("select OrderDate,OrderNumber,Notes,DimsOrderID,
                  intUserID,DeliveryAddress,CustomerContactCellphone,
                  CustomerContactEmail,bitCompleted,
                  iif(bitCompleted=0,'yellow','') as bColor

                from OrderHeaders
                inner join tblDIMSUSERS on tblDIMSUSERS.UserID = OrderHeaders.intUserId
                where OrderHeaders.CustomerCode='CAS004' ORDER BY OrderDate desc");
        //dd($ordSreening);
        return view ('dims/orderscreening')
            ->with('orderScrn',$ordSreening);
    }
    public function mymarketGetSales()
    {

        $results = "No Orders";

        try{


            $soapUrl = "http://mmcapp01.mymarket.com/SalesOrderService/SalesOrderService.asmx";
            // xml post structure

      /*      $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <GetSalesOrders xmlns="http://mymarket.salesorder.service">
                <MMCSalesOrderRequest xmlns="http://mymarket.salesorder.service.getorders">
                    <Request>
                        <Supplier ID="7e698636-42b8-4827-bd99-8e0f9172e0cc"
                        name="kerstont"
                        orgID="samstraining"
                        password="Test001"
                        salesOrderStatus="Accepted"
                        purchaseOrderNumber=""
                        accountNumber="" xmlns="http://mymarket.document.service.CommonType"/>
                    </Request>
                </MMCSalesOrderRequest>
            </GetSalesOrders>
        </soap:Body>
    </soap:Envelope>
    ';      */

      $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <GetSalesOrders xmlns="http://mymarket.salesorder.service">
                <MMCSalesOrderRequest xmlns="http://mymarket.salesorder.service.getorders">
                    <Request>
                        <Supplier ID="e37a34ca-a90b-4fcd-83be-eefa1ebc3b75"
                        name="integrationuser"
                        orgID="kerstonfoods"
                        password="System2016"
                        salesOrderStatus="Accepted"
                        purchaseOrderNumber=""
                        accountNumber="" xmlns="http://mymarket.document.service.CommonType"/>
                    </Request>
                </MMCSalesOrderRequest>
            </GetSalesOrders>
        </soap:Body>
    </soap:Envelope>
    ';

            $headers = array(
                "Content-Type: text/xml; charset=utf-8",
                "Accept: application/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: http://mymarket.salesorder.service/SalesOrderService/GetSalesOrders",
                "Content-length: ".strlen($xml_post_string),
            );

            $url = $soapUrl;


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch);
            // var_dump($response);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {

                $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
                $xml = new SimpleXMLElement($response);
                $body = $xml->xpath('//soapBody')[0];
                $array = json_decode(json_encode((array)$body), TRUE);

                $results = $array['GetSalesOrdersResponse']['MMCSalesOrderRequest']['Response']['Supplier']['SalesOrders']['SalesOrder'];

                $arrayLinesfinals = array();
                $arraydataset = array();

                for($k = 0; $k < count($results);$k++ )
                {

                    $arrayLines = array();
                    $allItems = $results[$k]['LineItems']['LineItem'];
//dd($results);
                    if(!isset($allItems['@attributes'])){
                        foreach ($results[$k]['LineItems']['LineItem'] as $key => $final){

                            $arrayLines[$key]['lineNumber']= $final['@attributes']['lineNumber'];
                            $arrayLines[$key]['partNumber']=$final['@attributes']['partNumber'];
                            $arrayLines[$key]['shortDescription']=$final['@attributes']['shortDescription'];
                            $arrayLines[$key]['deliveryDate']= (new \DateTime($final['@attributes']['deliveryDate']))->format('Y-m-d');
                            $arrayLines[$key]['barCode']=$final['@attributes']['barCode'];
                            $arrayLines[$key]['unitPriceExclTax']=$final['@attributes']['unitPriceExclTax'];
                            $arrayLines[$key]['DimsProductCode']=$final['@attributes']['buyerPartNumber'];
                            $arrayLines[$key]['quantity']=$final['@attributes']['quantity'];
                            $arrayLines[$key]['BuyingOrganisationName']=$results[$k]['BuyingOrganisation']['@attributes']['name'];
                            $arrayLines[$key]['BillToAddress']=$results[$k]['BillToAddress']['Address']['CompanyName1'];
                            $arrayLines[$key]['Comments']=$results[$k]['BillToAddress']['Address']['Comments'];
                            $arrayLines[$key]['ID']=$results[$k]['Header']['TradingPartners']['Buyer']['@attributes']['ID'];
                            $arrayLines[$key]['name']=$results[$k]['Header']['TradingPartners']['Buyer']['@attributes']['name'];
                            $arrayLines[$key]['orgID']=$results[$k]['Header']['TradingPartners']['Buyer']['@attributes']['orgID'];
                            $arrayLines[$key]['vatNumber']=$results[$k]['Header']['TradingPartners']['Buyer']['@attributes']['vatNumber'];
                            $arrayLines[$key]['salesOrderNumber']=$results[$k]['Header']['@attributes']['salesOrderNumber'];
                            $arrayLines[$key]['totalAmountExclTax']=$results[$k]['Header']['@attributes']['totalAmountExclTax'];
                            $arrayLines[$key]['totalAmountIncTax']=$results[$k]['Header']['@attributes']['totalAmountIncTax'];
                            $arrayLines[$key]['purchaseOrderNumber']=$results[$k]['Header']['@attributes']['purchaseOrderNumber'];
                            $arrayLines[$key]['transactionDate']=$results[$k]['Header']['@attributes']['transactionDate'];
                            $arrayLines[$key]['purchaseOrderDate']=$results[$k]['Header']['@attributes']['purchaseOrderDate'];



                        }
                    }else{

                        $final = $allItems['@attributes'];

                        $arrayLines[0]['lineNumber']= $final['lineNumber'];
                        $arrayLines[0]['partNumber']=$final['partNumber'];
                        $arrayLines[0]['shortDescription']=$final['shortDescription'];
                        $arrayLines[0]['deliveryDate']=(new \DateTime($final['deliveryDate']))->format('Y-m-d');
                        $arrayLines[0]['barCode']=$final['barCode'];
                        $arrayLines[0]['unitPriceExclTax']=$final['unitPriceExclTax'];
                        $arrayLines[0]['BuyingOrganisationName']=$results[$k]['BuyingOrganisation']['@attributes']['name'];
                        $arrayLines[0]['DimsProductCode']=$final['buyerPartNumber'];
                        $arrayLines[0]['quantity']=$final['quantity'];
                        $arrayLines[0]['BillToAddress']=$results[$k]['BillToAddress']['Address']['CompanyName1'];
                        $arrayLines[0]['Comments']=$results[$k]['BillToAddress']['Address']['Comments'];
                        $arrayLines[0]['ID']=$results[$k]['Header']['TradingPartners']['Buyer']['@attributes']['ID'];
                        $arrayLines[0]['name']=$results[$k]['Header']['TradingPartners']['Buyer']['@attributes']['name'];
                        $arrayLines[0]['orgID']=$results[$k]['Header']['TradingPartners']['Buyer']['@attributes']['orgID'];
                        $arrayLines[0]['vatNumber']=$results[$k]['Header']['TradingPartners']['Buyer']['@attributes']['vatNumber'];
                        $arrayLines[0]['salesOrderNumber']=$results[$k]['Header']['@attributes']['salesOrderNumber'];
                        $arrayLines[0]['totalAmountExclTax']=$results[$k]['Header']['@attributes']['totalAmountExclTax'];
                        $arrayLines[0]['totalAmountIncTax']=$results[$k]['Header']['@attributes']['totalAmountIncTax'];
                        $arrayLines[0]['purchaseOrderNumber']=$results[$k]['Header']['@attributes']['purchaseOrderNumber'];
                        $arrayLines[0]['transactionDate']=$results[$k]['Header']['@attributes']['transactionDate'];
                        $arrayLines[0]['purchaseOrderDate']=$results[$k]['Header']['@attributes']['purchaseOrderDate'];

                    }

                    $arrayLinesfinals[$k]=$arrayLines;
                }

                //dd($arrayLinesfinals);


            }

        }catch(Exception $e){
            echo $e->getMessage();
        }

        return $arrayLinesfinals;
        /*return view('dims/mymarket')
            ->with('orders', $arrayLinesfinals);*/

    }
    public function viewMyMarketOrders()
    {
        return view('dims/mymarket');
    }
    public function getMymarketOrdersToDealWith(Request $request)
    {
        $salesorderids = $request->get('salesorderids');
        $myMarketJson = $this->mymarketGetSales();
        $orderHeaders = array();
        $lines = array();
        $errors = array();
        $inv = 'id';

        $hCount = 0;
        $LinesCount = 0;

        for($i = 0; $i < count($myMarketJson); $i++){

            for( $k=0;$k < count($myMarketJson[$i]); $k++){
            //    var_dump("This is it ".in_array($myMarketJson[$i][$k]['salesOrderNumber'], $salesorderids). "***********ID****".$myMarketJson[$i][$k]['salesOrderNumber']);
                    if (in_array($myMarketJson[$i][$k]['salesOrderNumber'], $salesorderids)) {
                        //if ($inv != $myMarketJson[$i][$k]['salesOrderNumber']) {
                            //var_dump($myMarketJson[$i][$k]);
                            $lines[$LinesCount]['orderid'] = $myMarketJson[$i][$k]['salesOrderNumber'];
                            $lines[$LinesCount]['StoreName'] = $myMarketJson[$i][$k]['name'];
                            $lines[$LinesCount]['CustomerCode'] = $myMarketJson[$i][$k]['orgID'];
                            $lines[$LinesCount]['purchaseOrderDate'] = $myMarketJson[$i][$k]['purchaseOrderDate'];

                        //    $lines[$LinesCount]['orderid'] = $myMarketJson[$i][$k]['salesOrderNumber'];
                            $lines[$LinesCount]['lineNumber'] = $myMarketJson[$i][$k]['lineNumber'];
                            $lines[$LinesCount]['PastelCode'] = $myMarketJson[$i][$k]['partNumber'];
                            $lines[$LinesCount]['qty'] = $myMarketJson[$i][$k]['quantity'];
                            $lines[$LinesCount]['PastelDescription'] = $myMarketJson[$i][$k]['shortDescription'];
                            $lines[$LinesCount]['Price'] = $myMarketJson[$i][$k]['unitPriceExclTax'];
                            $lines[$LinesCount]['LinedeliveryDate'] = $myMarketJson[$i][$k]['deliveryDate'];

                          /*  $returnprinteddoc= DB::connection('sqlsrv2')
                                ->select("Exec spInsertIntoFlatMyMarketTable ?,?,?,?,?,?,?,?,?,?,?",
                                    array(  $myMarketJson[$i][$k]['partNumber']
                                            , $myMarketJson[$i][$k]['shortDescription']
                                            , $myMarketJson[$i][$k]['salesOrderNumber']
                                            , $myMarketJson[$i][$k]['orgID']
                                            , $myMarketJson[$i][$k]['name']
                                            , $myMarketJson[$i][$k]['purchaseOrderDate']
                                            , $myMarketJson[$i][$k]['lineNumber']
                                            , $myMarketJson[$i][$k]['quantity']
                                            , $myMarketJson[$i][$k]['unitPriceExclTax']
                                            , $myMarketJson[$i][$k]['deliveryDate'],1
                                    ));
                         */

                            $LinesCount++;
                    //    }
                    }
                        $inv = $myMarketJson[$i][$k]['salesOrderNumber'];
                }


        }
        $orderDetailsxml = $this->toxml($lines, "xml", array("result"));

        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spInsertIntoFlatMyMarketTable ?",
                array( $orderDetailsxml));
        return response()->json($returnprinteddoc);


    }
    public function postMyMarketOrders(Request $request)
    {
        $checkedLines = $request->get('checkedLines');
        $notCheckedLines = $request->get('notCheckedLines');
        $notCheckedLinesxml = $this->toxml($notCheckedLines, "xml", array("result"));
        $checkedLinesxml = $this->toxml($checkedLines, "xml", array("result"));

        //I need auth done it eventually
        $returnCustProdPrice = DB::connection('sqlsrv3')
            ->select('exec spCustomerPriceLookUpAssociatedItems ?,?',
                array($checkedLines,$notCheckedLines)
            );

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
