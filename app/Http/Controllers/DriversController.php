<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Controllers\DimsCommon;

class DriversController extends Controller
{
    //Drivers
    public function addItem(Request $request)
    {

        $DriverName = $request->get('DriverName');
        $GLCode = $request->get('GLCode');
        $insertDriver = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDDrivers NULL,'".$DriverName."','".$GLCode."','Insert'");
        return response()->json($insertDriver);

    }


    public function readItems(Request $request)
    {
        $DriverId = 0;
        $DriverName = "NULL";
        $GLCode = "NULL";
        $readDriver = DB::connection('sqlsrv3')
            ->select("EXEC spCRUDDrivers ".$DriverId.",'".$DriverName."','".$GLCode."','Select'");

        $glCode = DB::connection('sqlsrv3')
            ->select("SELECT * FROM tblGLCodes");


        return view('dims/drivers')
            ->with('glCode',$glCode)
            ->with('readItems',$readDriver);

    }

    public function cashCollectedReport($dateFrom,$dateTo)
    {
        $dateFrom= (new \DateTime($dateFrom))->format('Y-m-d');
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');
        $cashCollected = DB::connection('sqlsrv3')
            ->select('exec spCashCollected ?,?',
                array($dateFrom,$dateTo)
            );
        return response()->json($cashCollected);

    }
    public function getCashCollected()
    {
        return view('dims/cash_collected');
    }
    public function editItem(Request $request)
    {
        $DriverId = $request->get('DriverId');
        $DriverName = $request->get('DriverName');
        $GLCode = $request->get('GLCode');


        $updateDriver = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDDrivers ".$DriverId.",'".$DriverName."','".$GLCode."','Update'");
        return response()->json($updateDriver);

    }

    public function deleteItem(Request $request)
    {
        $DriverId = $request->get('DriverId');
        $DriverName = $request->get('DriverName');
        $GLCode = $request->get('GLCode');


        $deleteDriver = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDDrivers ".$DriverId.",'".$DriverName."','".$GLCode."','Delete'");
        return response()->json($deleteDriver);
    }

    //Trucks
    public function addTrucksItem(Request $request)
    {

        $TruckName = $request->get('TruckName');
        $RegNo = $request->get('RegNo');
        $Capacity = $request->get('Capacity');
        $insertTrucks = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDTrucks NULL,'".$TruckName."','".$RegNo."',".$Capacity.",'Insert'");
        return response()->json($insertTrucks);

    }

    public function readTrucksItems(Request $request)
    {
        $TruckId = 0;
        $TruckName = "NULL";
        $RegNo = "NULL";
        $Capacity = 0;
        $readTrucks = DB::connection('sqlsrv3')
            ->select("EXEC spCRUDTrucks ".$TruckId.",'".$TruckName."','".$RegNo."',".$Capacity.",'Select'");

        return view('dims/trucks')
            ->with('readTrucksItems',$readTrucks);
    }

    public function editTrucksItem(Request $request)
    {
        $TruckId = $request->get('TruckId');
        $TruckName = $request->get('TruckName');
        $RegNo = $request->get('RegNo');
        $Capacity = $request->get('Capacity');


        $updateTrucks = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDTrucks ".$TruckId.",'".$TruckName."','".$RegNo."',".$Capacity.",'Update'");
        return response()->json($updateTrucks);

    }

    public function deleteTrucksItem(Request $request)
    {
        $TruckId = $request->get('TruckId');
        $TruckName = "NULL";//$request->get('TruckName');
        $RegNo = "NULL";//$request->get('RetgNo');
        $Capacity = 0;


        $deleteTrucks = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDTrucks ".$TruckId.",'".$TruckName."','".$RegNo."',".$Capacity.",'Delete'");
        return response()->json($deleteTrucks);
    }





    //Routes

    public function addRoutesItem(Request $request)
    {
        $Route = $request->get('Route');
        $location = $request->get('location');
        // dd("EXEC spCRUDRoutes NULL,'".$Route."','Insert'");
        $userAuthID = \Illuminate\Support\Facades\Auth::user()->GroupId;
        $v  =  new \App\Http\Controllers\SalesForm();
        $things = $v->getThings($userAuthID,'Add Routes');
        if($things != "0") {
            $insertRoutes = DB::connection('sqlsrv3')
                ->statement("EXEC spCRUDRoutes $location,'" . $Route . "','Insert'");
        }
        return response()->json($Route);

    }

    public function readRoutesItems(Request $request)
    {
        $Routeid = 0;
        $Route = "NULL";
        $userAuthID = \Illuminate\Support\Facades\Auth::user()->GroupId;
        $v  =  new \App\Http\Controllers\SalesForm();
        $readRoutes = DB::connection('sqlsrv3')
            ->select("EXEC spCRUDRoutes ".$Routeid.",'".$Route."','Select'");
        $things = $v->getThings($userAuthID,'Add Routes');
        $locations = DB::connection('sqlsrv3')
            ->select("Select * from tblLocations");

        return view('dims/routes1')->with('locations',$locations)
            ->with('readRoutesItems',$readRoutes)->with('routesfullaccess',$things);
    }
    public function deliveryaddresspage()
    {
       $routes=  DB::connection('sqlsrv3')
            ->select("Select Routeid, Route from tblRoutes");
        
       $deliveryaddress=  DB::connection('sqlsrv3')
       ->select("Select * from viewCustomerDeliveryAddress");
        return view('dims/deliveryaddresseditor')->with('deliveryaddress',$deliveryaddress)
        ->with('routes', $routes);
    }
public function updateDeliveryAddressesGrid(Request $request){
    $sessionUserId = Auth::user()->UserID;
    $userName = Auth::user()->UserName;
    $deladdID = $request->get('ID');
    $deladd1 = $request->get('DAddress1');
    $deladd2 = $request->get('DAddress2');
    $deladd3 = $request->get('DAddress3');
    $deladd4 = $request->get('DAddress4');
    $deladd5 = $request->get('DAddress5');
    $route = $request->get('Route');
    DB::connection('sqlsrv3')
                ->statement("EXEC spDeliveryAddressUpdate ?,?,?,?,?,?,?,?,?",
                    array($deladdID,$deladd1,$deladd2,$deladd3,$deladd4,$deladd5,$route,$sessionUserId,$userName));
}
    public function editRoutesItem(Request $request)
    {
        $Routeid = $request->get('Routeid');
        $Route = $request->get('Route');
        $locationID = $request->get('locationID');

        DB::connection('sqlsrv3')->table('tblRoutes')
            ->where('Routeid', $Routeid)
            ->update(['LocationId' =>$locationID]);
        $updateRoutes = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDRoutes ".$Routeid.",'".$Route."','Update'");
        return response()->json($updateRoutes);

    }

    public function deleteRoutesItem(Request $request)
    {
        $Routeid = $request->get('Routeid');
        $Route = $request->get('Route');


        $deleteRoutes = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDRoutes ".$Routeid.",'".$Route."','Delete'");
        return response()->json($deleteRoutes);
    }
    public function addGLCode(Request $request)
    {


        $GLCode = $request->get('GLCode');
        $insertGLCode = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDGLCodes NULL,".$GLCode.",'Insert'");
        return response()->json($insertGLCode);

    }


    public function readGLCode(Request $request)
    {
        $GLId = 0;
        $GLCode = 0;
        $readGLCodes = DB::connection('sqlsrv3')
            ->select("EXEC spCRUDGLCodes ".$GLId.",".$GLCode.",'Select'");



        return view('dims/glcodes')
            ->with('readGLCode',$readGLCodes);

    }

    public function editGLCode(Request $request)
    {
        $GLId = $request->get('GLId');
        $GLCode = $request->get('GLCode');


        $updateGLCodes = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDGLCodes ".$GLId.",".$GLCode.",'Update'");
        return response()->json($updateGLCodes);

    }

    public function deleteGLCode(Request $request)
    {
        $GLId = $request->get('GLId');
        $GLCode = $request->get('GLCode');


        $deleteGLCodes = DB::connection('sqlsrv3')
            ->statement("EXEC spCRUDGLCodes ".$GLId.",".$GLCode.",'Delete'");
        return response()->json($deleteGLCodes);
    }
    public function driverspdfdocs()
    {
        $sessionUserId = Auth::user()->UserID;
        $pdfdocs = DB::connection('sqlsrv3')
            ->select(" Exec spGetPDFdocs $sessionUserId"); //WHERE ID = ''

        /*foreach ($pdfdocs as $val)
        {
            $data = base64_decode($val->strPDF) ;
            header('Content-Type: application/pdf');
            echo $data;

            dd();
        }*/
        $Deldate = (new \DateTime())->format('Y-m-d');
        return view('dims/driversappdocs')->with('pdfdocs',$pdfdocs)->with('deldate',$Deldate);
    }
    public function cashupscheckinvoice($invoice)
    {
        $pdfdocs = DB::connection('sqlsrv3')
            ->select(" Exec spGetInvoiceCashUpMessage '$invoice'");
        return view('dims/cashmessages')->with('invoiceinfo',$pdfdocs)->with('invoicenumber',$invoice);
    }
    public function postcashupscheckinvoice(Request $request)
    {
        $message = $request->get('invoiceMessage');
        $sorted= $request->get('sorted');
        $orderId = $request->get('orderid');

        DB::connection('sqlsrv3')->table('tblOrders')
            ->where('OrderId',$orderId )
            ->update(['strCashUpMessages' => $message,'bitCashUpCheckedIt' => $sorted]);
    }
    public function postPODSToTheAccounting(Request $request)
    {
        $checkedInvoices = $request->get('checkedInvoices');
//spInsertPODToPalladium
        foreach ($checkedInvoices as $value) {
            $invoiceNumber = $value['invoiceNo'];
            DB::connection('sqlsrv3')
                ->statement("Exec spInsertPODToPalladium '$invoiceNumber'");
        }

        dd($checkedInvoices);
    }
    public function invoicessignedaroundpremises(Request $request)
    {
        $deldate = $request->get('deldate');
        $deldate =  (new \DateTime($deldate))->format('Y-m-d');
        $invoicessignedaround= DB::connection('sqlsrv3')
            ->select("EXEC spDocumentsSignedWithoutGeoFence '".$deldate."'");
        return response()->json($invoicessignedaround);
    }
    public function driverspdfdocsByInv(Request $request)
    {
        $InvoiceNo = $request->get('InvocieNo');
        $pdfdocs = DB::connection('sqlsrv3')
                ->select(" Exec spReturnA4OrNormalPDF ?",
                    array($InvoiceNo));
        $creditReq = DB::connection('sqlsrv3')
            ->select("select TOP 1 *, cast('' as xml).value('xs:base64Binary(sql:column(\"imgPDF\"))', 'varchar(max)') as strPDF FROM tblPrintedDocumentsFiles where [strDocNumber]='$InvoiceNo' AND strDocumentType='CreditRequisition'"); //WHERE ID = ''

        // dd($pdfdocs);
        // $output['data'] = $pdfdocs;
        $i = 0;
        $output = array();
        $output2 = array();
        foreach($pdfdocs as $val)
        {
            $output[$i]['strPDF'] = $val->strPDF;
            $output[$i]['strDocNumber'] = $val->strDocNumber;
            $output[$i]['DriverName'] = $val->DriverName;
            $output[$i]['strLoadedBy'] = $val->strLoadedBy;
            $output[$i]['strDocumentType'] = $val->strDocumentType;
            $i++;
        }
        foreach($creditReq as $val)
        {
            $i = 0;
            $output2[$i]['strPDF'] = $val->strPDF;
            $output2[$i]['strDocNumber'] = $val->strDocNumber;
            $i++;
        }
        $results['pdfdocs'] = $output;
        $results['pdfdocsrequ'] = $output2;
        return $results;//response()->json($pdfdocs);
    }
    public function driverpdfdocrequisition(Request $request)
    {
        $InvoiceNo = $request->get('InvocieNo');
        $pdfdocs = DB::connection('sqlsrv3')
            ->select("select TOP 1 *, cast('' as xml).value('xs:base64Binary(sql:column(\"imgPDF\"))', 'varchar(max)') as strPDF FROM tblPrintedDocumentsFiles where [strDocNumber]='$InvoiceNo' AND strDocumentType='CreditRequisition'"); //WHERE ID = ''
        // dd($pdfdocs);
        // $output['data'] = $pdfdocs;
        $i = 0;
        foreach($pdfdocs as $val)
        {
            $output[$i]['strPDF'] = $val->strPDF;
            $output[$i]['strDocNumber'] = $val->strDocNumber;
            $i++;
        }

        return $output;//response()->json($pdfdocs);
    }
    public function driverspdfdocsByInvsubinfo(Request $request)
    {
        $InvoiceNo = $request->get('InvocieNo');
        $pdfdocs = DB::connection('sqlsrv3')
            ->select("select InvoiceNo,od.offLoadComment,od.returnQty,od.Qty,od.strCustomerReason,od.Comment,o.strNotesDrivers,p.PastelDescription,p.PastelCode,o.mnyDriverCash from tblOrders
 as o inner join tblOrderDetails as od
 ON o.OrderId =od.OrderId
 inner join viewtblProducts p
 on p.productid = od.productid
where o.InvoiceNo='$InvoiceNo'"); //WHERE ID = ''
        // dd($pdfdocs);
        // $output['data'] = $pdfdocs;

        $i = 0;
        foreach($pdfdocs as $val)
        {
            $output[$i]['offLoadComment'] = $val->offLoadComment;
            $output[$i]['returnQty'] = $val->returnQty;
            $output[$i]['Qty'] = $val->Qty;
            $output[$i]['strCustomerReason'] = $val->strCustomerReason;
            $output[$i]['officeComment'] = $val->Comment;
            $output[$i]['strNotesDrivers'] = $val->strNotesDrivers;
            $output[$i]['PastelDescription'] = $val->PastelDescription;
            $output[$i]['PastelCode'] = $val->PastelCode;
            $output[$i]['mnyDriverCash'] = $val->mnyDriverCash;
            $i++;
        }
        return $output;//response()->json($pdfdocs);
    }

    public function driverspdfdocsBytripsheet(Request $request)
    {
        $routingId = $request->get('routingId');
        $pdfdocs = DB::connection('sqlsrv3')
            ->select("select v.InvoiceNo, cast('' as xml).value('xs:base64Binary(sql:column(\"imgPDF\"))', 'varchar(max)') as strPDF,dbo.fnDriverNameOnInvoice(v.InvoiceNo) as DriverName ,
dbo.fnRouteLoader($routingId) as strLoadedBy,bitCashUpCheckedIt cashdealtwithit
	from tblOrders v
	inner join tblDeliveryDateRouting dr
	on dr.OrderTypeId = v.LateOrder and dr.DeliveryDate = v.DeliveryDate and dr.RouteId = v.RouteId
	inner join tblPrintedDocumentsFiles f
	on f.strDocNumber=v.InvoiceNo
	where dr.DeliveryDateRoutingID  = '$routingId'  and f.strDocumentType='A4Invoice' order by DeliverySequence");
        $pdfdocspaid = DB::connection('sqlsrv3')
            ->select("select v.InvoiceNo, cast('' as xml).value('xs:base64Binary(sql:column(\"imgPDF\"))', 'varchar(max)') as strPDF,v.mnyDriverCash,bitCashUpCheckedIt cashdealtwithit
	from  tblOrders v
	inner join tblDeliveryDateRouting dr
	on dr.OrderTypeId = v.LateOrder and dr.DeliveryDate = v.DeliveryDate and dr.RouteId = v.RouteId
	inner join tblPrintedDocumentsFiles f
	on f.strDocNumber=v.InvoiceNo
	where dr.DeliveryDateRoutingID  = '$routingId'  and f.strDocumentType='A4Invoice'");
        $requisition = DB::connection('sqlsrv3')
            ->select("select v.InvoiceNo, cast('' as xml).value('xs:base64Binary(sql:column(\"imgPDF\"))', 'varchar(max)') as strPDF,bitCashUpCheckedIt cashdealtwithit
	from tblOrders v
	inner join tblDeliveryDateRouting dr
	on dr.OrderTypeId = v.LateOrder and dr.DeliveryDate = v.DeliveryDate and dr.RouteId = v.RouteId
	inner join tblPrintedDocumentsFiles f
	on f.strDocNumber=v.InvoiceNo
	where dr.DeliveryDateRoutingID = '$routingId'  and f.strDocumentType='CreditRequisition'"); //WHERE ID = ''
        // dd($pdfdocs);
        // $output['data'] = $pdfdocs;
        $i = 0;
        $output = array();
        $output2 = array();
        $output3 = array();
        foreach($pdfdocs as $val)
        {
            $output[$i]['strPDF'] = $val->strPDF;
            $output[$i]['strDocNumber'] = $val->InvoiceNo;
            $output[$i]['DriverName'] = $val->DriverName;
            $output[$i]['strLoadedBy'] = $val->strLoadedBy;
            $output[$i]['cashdealtwithit'] = $val->cashdealtwithit;
            $i++;
        }
        $i = 0;

        $cash = 0;
        $Total = 0;
        foreach($pdfdocspaid as $val)
        {
            if ($val->mnyDriverCash > 0)
            {
                $output2[$i]['strPDF'] = $val->strPDF;
                $output2[$i]['strDocNumber'] = $val->InvoiceNo;
                $cash = $cash + $val->mnyDriverCash;


                $i++;
            }

        }
        $output2[$i-1]['mnyDriverCash'] = $cash;
        $i = 0;
        foreach($requisition as $val)
        {
            $output3[$i]['strPDF'] = $val->strPDF;
            $output3[$i]['strDocNumber'] = $val->InvoiceNo;
            $i++;
        }
        $results['pdfdocs'] = $output;
        $results['pdfdocspaid'] = $output2;
        $results['pdfdocrequisition'] = $output3;
        return $results;//response()->json($pdfdocs);
    }
    public function getdriversandinfo($date1,$date2)
    {
        //
        $driver = DB::connection('sqlsrv3')
            ->select("EXEC spDriverPerformance '".$date1."','".$date2."'");
        return response()->json($driver);
    }
    public function isCheckedCashUp(Request $request)
    {
       $invoiceNo = $request->get('InvoiceNumber');
       $checkboxflag = $request->get('checkboxflag');

       dd($checkboxflag);
    }
    public function driversperformancereport()
    {
        return view('dims/drivers_report');
    }
    public function getNoOfDelPerCustomer($date1,$date2)
    {
        $driver = DB::connection('sqlsrv3')
            ->select("EXEC spNumberOfDelPerCustomers '".$date1."','".$date2."'");
        return response()->json($driver);
    }
    public function noOfStops()
    {
        return view('dims/numberofdeliveries_report');
    }
    public function creditRequisitionByRoutingId($routingId)
    {
        return view('dims/requisition_by_routingid')->with('RoutingId',$routingId);
    }
    public function checkingDriversStockAndComment($orderdetailID)
    {
        $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
            ->select("EXEC spDriversAppRequisitionMessage ".$orderdetailID);
        return view('dims/updatedriversreturncomment')->with('orderdetailID',$gridcustomerjsonspecials);
    }
    public function updatereturndispatchmessage(Request $request)
    {
        $v  =  new \App\Http\Controllers\SalesForm();
        $orderdetailId = $request->get('orderdetailId');
        $strCustomerReason = $request->get('strDispatchComments');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $GroupId = Auth::user()->GroupId;
        $dealwithreturns = $v->getThings($GroupId,'Deal With Approved Returns');
        $approvereturns = $v->getThings($GroupId,'Approve Returns');//warehouse user

        $returnstatement="false";
        if($approvereturns == 1)
        {
            $returnstatement =  DB::connection('sqlsrv3')
                ->statement("EXEC spDriversAppUpdateComments ?,?,?",
                    array($orderdetailId,$strCustomerReason,$userName));
        }
        if($dealwithreturns == 1)
        {
            $returnstatement =  DB::connection('sqlsrv3')
                ->statement("EXEC spDriversAppCreditDeptApproved ?,?,?",
                    array($orderdetailId,$strCustomerReason,$userName));
        }

        return response()->json($returnstatement);
    }
    public function LiveDriverStops()
    {

        $delvDate ='2019-04-18';// (new \DateTime())->format('Y-m-d');
        $driverOnDuty = DB::connection('sqlsrv4')->select("EXEC spDriversOnDuty '".$delvDate."'");
        $driverStops = DB::connection('sqlsrv4')->select("EXEC spLiveDriverStops '".$delvDate."'");
        $square = array("[", "]");
        $html ="<!DOCTYPE html>
<html>
<head>

</head>
<body style=\"font-family: Sans-serif\">";
        $html .= "<table style='width:100% ;background: black;color: white;border: 1px solid white;'>";
        foreach ($driverOnDuty as $val) {
            $strippedDriver = str_replace($square, "", $val->drivers);
            $array = explode(',', $strippedDriver);

            $user = "";
            for ($i=0;$i < count($array);$i++) {
                $html .= "<tr>";
                $names = $array[$i];
                $html .="<td >".$names."</td>";
                foreach ($driverStops as $stops) {
                    //echo $array[$i];
                    //
                    $substring = substr($stops->$names, 0,4);
                    $new = strstr($stops->$names, '---');
                    // dd( substr($new,5,-1)) ;
                    if($substring=="Prog" || $stops->$names==null ){
                        $html .="<td style='width: 100px;font-weight: 900;'>".substr(strstr($stops->$names, '---'),5,-1)."</td>";
                    }else{
                        $html .="<td style='width: 100px;background: #0BA008;color:black;font-weight: 900;'>".substr(strstr($stops->$names, '---'),5,-1)."</td>";
                    }

                }
                $html .= "</tr>";

            }
        }
        $html .= "</table></body>
</html>";
        echo $html;
        //return response()->json($driver);
    }
    public function getdriverscashoff()
    {
        //
        $tax= DB::connection('sqlsrv4')
            ->select('select* from tblTaxes where TaxCode is not null');

        $tblGLCodes= DB::connection('sqlsrv4')
            ->select('select* from vwGLCode ');
        $returnRefs= DB::connection('sqlsrv4')
            ->select('select * from vwDriversCashoffTopReferences');

        return view('dims/driverscashoffpage')->with('tax',$tax)->with('references',$returnRefs)
            ->with('glCode',$tblGLCodes);
    }
    public function getDriversCashOffJson(Request $request)
    {
        $refNo = $request->get('refNo');
        $refType = $request->get('refType');

        $driverscashoff= DB::connection('sqlsrv4')
            ->select('exec spDriversCash ?,?',
                array($refNo,$refType)
            );
        $getdriverscashoffCash = DB::connection('sqlsrv4')
            ->select('exec [spGetDriversCashOffCash] ?',
                array($refNo)
            );
        $returnexpenses = DB::connection('sqlsrv4')
            ->select('exec [spGetExpenses] ?',
                array($refNo)
            );
        $returnRefs= DB::connection('sqlsrv4')
            ->select("select DeliveryDateRoutingID,Exported,[Reference Number] as Ref from tblDriversCashOff where iif('$refType'='USEREF', [Reference Number],DeliveryDateRoutingID) =".$refNo);
        //dd("select DeliveryDateRoutingID,Exported,[Reference Number] as Ref from tblDriversCashOff where iif('$refType'='USEREF', [Reference Number],DeliveryDateRoutingID) =".$refNo);
        $outPut['infoList'] = $driverscashoff;
        $outPut['reference'] = $returnRefs;
        $outPut['cashoffcash'] = $getdriverscashoffCash;
        $outPut['expenses'] = $returnexpenses;
        return response()->json($outPut);
    }
    public function createnewsheet(Request $request)
    {
        $newSheet = DB::connection('sqlsrv4')
            ->select('exec spCreateDriverCashOffSheet ');

        return response()->json($newSheet);
    }
    public function printDriversCashOff($ref)
    {
        $userName = $userid = Auth::user()->UserName;
        $returnCashOff = DB::connection('sqlsrv4')
            ->select("select * from vwDriversCashOffJasper where  ref=$ref");

        return view('dims/print_preview_cashoff')
            ->with('invoices',$returnCashOff);
    }
    public function postDriversCashOff(Request $request)
    {
        $routingID = $request->get('routingID');
        $driverId = $request->get('driverId');
        $xmls = $request->get('xmls');
        $notes = $request->get('notes');
        $cashtotals = $request->get('cashtotals');
        $invtotals = $request->get('invtotals');
        $xmlsExpense = $request->get('xmlsExpense');
        $xmlcashqty = $request->get('xmlcashqty');
        $xmlcashNotes = $request->get('xmlcashNotes');
        $btnVal = $request->get('btnVal');
        $ref = $request->get('ref');
        $userid = Auth::user()->UserID;

        if (count($xmls) > 0) {
            $orderDetailsxml = $this->toxml($xmls, "xml", array("result"));

            $Expensexml = $this->toxml($xmlsExpense, "xml", array("result"));
            $cashNotesxml = $this->toxml($xmlcashNotes, "xml", array("result"));
            $cashqtyxml = $this->toxml($xmlcashqty, "xml", array("result"));
            $salesreportinfo = DB::connection('sqlsrv4')
                ->select('exec spDriversCashOff ?,?,?,?,?,?,?,?,?,?,?',
                    array($driverId, $cashtotals, $routingID, $userid, $invtotals, $notes, $orderDetailsxml, $Expensexml,$ref,$cashqtyxml,$cashNotesxml)
                );
            if($btnVal == "export")
            {
                $exported = DB::connection('sqlsrv4')
                    ->statement('exec spDriversCashOffExport ?,?',
                        array($ref, $userid)
                    );
            }
            if($btnVal == "Print")
            {
                return "Print";
            }
        }
    }
    public function getRoutingIds(Request $request)
    {
        $deliveryDate=$request->get('deliveryDate');
        $deliveryDate =  (new \DateTime($deliveryDate))->format('Y-m-d');
        $listOfRoutingIds= DB::connection('sqlsrv4')
            ->select('exec spOnPODscreenRoutingIDs ?',
                array($deliveryDate)
            );
        return response()->json($listOfRoutingIds);
    }
    public function exportCashOff(Request $request)
    {
        $ref = $request->get('ref');
        $userid = Auth::user()->UserID;
        $exported = DB::connection('sqlsrv4')
            ->statement('exec spDriversCashOffExport ?,?',
                array($ref, $userid)
            );
        return response()->json($exported);
    }
    public function CreditDeptComment($orderdetailID)
    {
        $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
            ->select("EXEC spDriversAppRequisitionMessage ".$orderdetailID);
        return view('dims/creditdeptcomments')->with('orderdetailID',$gridcustomerjsonspecials);
    }
    public function CreditDeptCommentUpdate(Request $request)
    {
        $v  =  new \App\Http\Controllers\SalesForm();
        $orderdetailId = $request->get('orderdetailId');
        $strCustomerReason = $request->get('strDispatchComments');
        $creditDeptMessage = $request->get('creditDeptMessage');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $GroupId = Auth::user()->GroupId;
        $dealwithreturns = $v->getThings($GroupId,'Deal With Approved Returns');

        $returnstatement="false";

        if($dealwithreturns == 1)
        {
            $returnstatement =  DB::connection('sqlsrv3')
                ->statement("EXEC spDriversAppCreditDeptApproved ?,?,?",
                    array($orderdetailId,$creditDeptMessage,$userName));
        }

        return response()->json($returnstatement);
    }

    public function getResendEmail(Request $request){

        return view('dims/resendemail');
    }
    public function getResendEmailJson(Request $request)
    {
        $invoiceNumber=$request->get('invoiceNumber');
        $returnstatement =  DB::connection('sqlsrv3')
            ->select("EXEC spResendInvoicess ?",
                array($invoiceNumber));

        return response()->json($returnstatement);
    }
    public function postResendEmailJson(Request $request)
    {
        $id=$request->get('id');
        $Email=$request->get('Email');
        $invoiceNumber=$request->get('invoiceNumber');
        $returnstatement =  DB::connection('sqlsrv3')
            ->statement("EXEC spResendInvoicesspost ?,?,?",
                array($id,$Email,$invoiceNumber));

        return response()->json($returnstatement);
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
