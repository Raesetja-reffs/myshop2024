<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExternalFunctions extends Controller
{
    //
    public function briefcaseDamages()
    {
        $today = (new \DateTime())->format('Y-m-d');
        $damagesHeaders = DB::connection('linxbriefcase')->table('vwExternalDamagesFromBriefcase')
            ->select('ID','CustomerCode','CustomerStoreName','OrderDate','DeliveryDate','OrderNumber','UserName','Notes')
            ->get();
        return view('dims/damages')->with('damages',$damagesHeaders)->with('today',$today);
    }
    public function damageshistory()
    {
        $today = (new \DateTime())->format('Y-m-d');

        return view('dims/damages_history')->with('today',$today);
    }
    public function getDamgedLines(Request $request)
    {
        $ID = $request->get('ID');
        $getDamagedLines= DB::connection('linxbriefcase')
            ->select("EXEC spGetDamgedLines '".$ID."'");

        return response()->json($getDamagedLines);
    }
    public function getDamagesHistoryHeader(Request $request)
    {
        $from= (new \DateTime( $request->get('from')))->format('Y-m-d');
        $to = (new \DateTime($request->get('to')))->format('Y-m-d');
        $getDamagedHistory= DB::connection('linxbriefcase')
            ->select("EXEC spDamagesHistoryHeader '".$from."','".$to."'");

        $output['recordsTotal'] = count($getDamagedHistory);
        $output['data'] = $getDamagedHistory;
        $output['recordsFiltered'] = $output['recordsTotal'];

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }
    public function popUpDamagesHistoryLines(Request $request)
    {
        $id = $request->get('ID');
    }
    public function printDamages($ID)
    {
        $damagesHeaders = DB::connection('linxbriefcase')->table('vwExternalDamagesFromBriefcaseSimpleHeader')
            ->select('ID','CustomerCode','CustomerStoreName','OrderDate','DeliveryDate','OrderNumber','UserName','Notes')
            ->where('ID',$ID)
            ->get();
        $getDamagedLines= DB::connection('linxbriefcase')
            ->select("EXEC spGetDamgedLines '".$ID."'");

        return view('dims/damages_print')->with('damagesheader',$damagesHeaders)->with('damageslines',$getDamagedLines);
    }

    public function deleteDamagedLine(Request $request)
    {
        $id = $request->get('ID');
        $prodCode = $request->get('prodCode');
        DB::connection('linxbriefcase')->table('OrderLines')
            ->where('ID',$id )
            ->where('strPartNumber',$prodCode )
            ->delete();
        return "deleted";

    }
    public function processDamage($ID)
    {
        $damagesHeaders = DB::connection('linxbriefcase')->table('vwExternalDamagesFromBriefcase')
            ->select('ID','CustomerCode','CustomerStoreName','OrderDate','DeliveryDate','OrderNumber','UserName','Notes')
            ->where('ID',$ID)
            ->get();
        $getDamagedLines= DB::connection('linxbriefcase')
            ->select("EXEC spGetDamgedLines '".$ID."'");

        DB::connection('linxbriefcase')->table('OrderHeaders')
            ->where('ID',$ID )
            ->update(['OrderNumber' => 'Dealt With']);

        return view('dims/process_damages')->with('damagesheader',$damagesHeaders)->with('damageslines',$getDamagedLines);
    }
    public function synchProducts()
    {

        set_time_limit(0);
        $counter = 0;
        $damagesHeaders = DB::connection('robbergstore')
            ->select("	SELECT  [CustomerPastelCode],[DAddress1]
      ,[DAddress2]
      ,[DAddress3]
      ,[DAddress4]
      ,[DAddress5]
      ,[DeliveryAddressId]
	   ,[RouteID],getdate() as lastSynch,1 as status
  FROM [linxdbDIMS].[dbo].[_viewBriefcaseCustomerDeliveryAddresses] ");

        foreach($damagesHeaders as $value)
        {
            /*$getCustomerPastelCode = DB::connection('webstore')->table('DeliveryAddress')
                ->select('CustomerPastelCode')
                ->where('CustomerPastelCode',$value->CustomerPastelCode)
                ->get();
            if (count($getCustomerPastelCode) > 0 )
            {
                //update
                DB::connection('webstore')->table('DeliveryAddress')
                    ->where('CustomerPastelCode',$value->CustomerPastelCode )
                    ->update(['DAddress1' => $value->DAddress1,'DAddress2'=>$value->DAddress2,'DAddress3' => $value->DAddress3,'DAddress4'=>$value->DAddress3,
                        'DAddress5'=>$value->DAddress5,'RouteID'=>$value->RouteID,'DeliveryAddressId'=>$value->DeliveryAddressId,
                        'lastSynch'=>$value->lastSynch,'status'=>2]);

            }else{
                //insert*/
                DB::connection('webstore')->table('DeliveryAddress')->insert(
                    ['DAddress1' => $value->DAddress1,'DAddress2'=>$value->DAddress2,'DAddress3' => $value->DAddress3,'DAddress4'=>$value->DAddress3,
                        'DAddress5'=>$value->DAddress5,'RouteID'=>$value->RouteID,'DeliveryAddressId'=>$value->DeliveryAddressId,'CustomerPastelCode'=>$value->CustomerPastelCode,
                        'lastSynch'=>$value->lastSynch,'status'=>1]
                );
            //}
            $counter++;
        }
       return $counter;

    }

    public function testWebstoreSpeed()
    {
        set_time_limit(0);
        $counter = 0;
        $damagesHeaders = DB::connection('webstore')
            ->select("	SELECT  [CustomerPastelCode]
      ,[DeliveryAddressId]
      ,[DAddress1]
      ,[DAddress2]
      ,[DAddress3]
      ,[DAddress4]
      ,[DAddress5]
      ,[RouteID]
      ,[lastSynch]
      ,[status]
   FROM [LinxBriefcase].[dbo].[DeliveryAddress]");

        foreach($damagesHeaders as $value)
        {  $counter++;
        }
        return $counter;

    }
    public function brifcaseCustomerEdits()
    {
        $getCustomers= DB::connection('linxbriefcase')
            ->select("EXEC spGetCustomersToViewOnDims");
        return view('dims/briefcase_customer_edit')->with('customeredit',$getCustomers);
    }
    public function updatevisits(Request $request)
    {
        $items = $request->get('items');
        $result = count($items);
        if($result > 0) {
            foreach ($items as $value) {
                DB::connection('linxbriefcase')->table('Customers')
                    ->where('CustomerCode',$value['code'])
                    ->update(['intVisitPeriod' => $value['period']]);
            }
        }
    }
    public function viewVisits()
    {
        /*$visits = DB::connection('linxbriefcase')
            ->select("Select Top 10000 * from  viewVisits");*/
        return view('dims/visitdatesandlocations')->with('visits');
    }
    public function visitsdates($datefrom,$datetto)
    {
        $from= (new \DateTime( $datefrom))->format('Y-m-d');
        $to = (new \DateTime($datetto))->format('Y-m-d');
        $visits = DB::connection('linxbriefcase')
            ->select("Select * from  viewVisits where dteCreated >= '$from' and dteCreated<='$to'");
        return view('dims/viewvisits')->with('visits',$visits);
    }
    public function viewDeals()
    {
        $deals = DB::connection('linxbriefcase')
            ->select("Select Top 10000 * from  viewDeals order by Margin desc");
        return view('dims/viewdeals')->with('deals',$deals);
    }
    //dealsdates
    public function dealsdates($datefrom,$datetto)
    {
        $from= (new \DateTime( $datefrom))->format('Y-m-d');
        $to = (new \DateTime($datetto))->format('Y-m-d');
        $deals = DB::connection('linxbriefcase')
            ->select("Select * from  viewDeals where (dteFrom <='$to' and dteFrom >='$from' ) or  (dteTo <='$to'  and dteTo >='$from')");
        return view('dims/viewdeals')->with('deals',$deals);
    }
    public function viewMissedVisit()
    {

        return view('dims/notVisited');
    }
    public function assets()
    {
        $assets = DB::connection('linxbriefcase')
            ->select("Select * from  viewAssets");
        $queryCustomers =DB::connection('linxbriefcase')->select("  select distinct [strCustomerCode],[strCustomerName] from tblAssets");

        return view('dims/assets')->with('assets',$assets)->with('customers',$queryCustomers);
    }

    public function crudasset($assetID)
    {
        if($assetID =='xxxx')
        {
            $assetID = 0;
        }

        $assets = DB::connection('linxbriefcase')
            ->select("Select * from  viewAssets where ID=$assetID");
        return view('dims/add_edit_assets')->with('assets',$assets)->with('ID',$assetID);
    }
    public function webstore()
    {

        return view('dims/webstore');
    }
    public function synchwebstore()
    {
        $syncweb= DB::connection('sqlsrv3')
            ->statement("EXEC SynchBriefcaseCommonProcedures");

        return view('dims/webstore')->with('syncresult',$syncweb);
    }
    public function saveupdateasset(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $customerCode = !empty($customerCode) ? $customerCode : "NULL";
        $customerName = $request->get('customerName');
        $customerName = !empty($customerName) ? $customerName : "NULL";
        $contactPerson = $request->get('contactPerson');
        $contactPerson = !empty($contactPerson) ? $contactPerson : "NULL";
        $contacttel = $request->get('contacttel');
        $contacttel = !empty($contacttel) ? $contacttel : "NULL";
        $cellnumber = $request->get('cellnumber');
        $cellnumber = !empty($cellnumber) ? $cellnumber : "NULL";
        $area = $request->get('area');
        $area = !empty($area) ? $area : "NULL";
        $address = $request->get('address');
        $address = !empty($address) ? $address : "NULL";
        $placement = $request->get('placement');
        $placement = !empty($placement) ? $placement : "NULL";
        $base = $request->get('base');
        $base = !empty($base) ? $base : "NULL";
        $assetname = $request->get('assetname');
        $assetname = !empty($assetname) ? $assetname : "NULL";
        $status = $request->get('status');
        $status = !empty($status) ? $status : "NULL";
        $serialno = $request->get('serialno');
        $serialno = !empty($serialno) ? $serialno : "NULL";
        $branding = $request->get('branding');
        $branding = !empty($branding) ? $branding : "NULL";
        $model = $request->get('model');
        $model = !empty($model) ? $model : "NULL";
        $make = $request->get('make');
        $make = !empty($make) ? $make : "NULL";
        $purch = $request->get('purch');
        $purch = !empty($purch) ? $purch : "NULL";
        $assetlastvisisted = $request->get('assetlastvisisted');
        $assetlastvisisted = !empty($assetlastvisisted) ? $assetlastvisisted : "NULL";
        $assettype = $request->get('assettype');
        $assettype = !empty($assettype) ? $assettype : "NULL";
        $latitude = $request->get('latitude');
        $latitude = !empty($latitude) ? $latitude : 0.0;
        $longitude = $request->get('longitude');
        $longitude = !empty($longitude) ? $longitude : 0.0;
        $history = $request->get('history');
        $history = addslashes($history);
        $history = !empty($history) ? $history : "NULL";
        $description = $request->get('description');
        $description = !empty($description) ? $description : "NULL";

        $qty = $request->get('qty');
        $qty = !empty($qty) ? $qty : "NULL";
        $id = $request->get('id');
        $return = "";
$history = $this->convertUtf8( $history );
        $captured = (new \DateTime())->format('Y-m-d H:i:s');
        if($id !=0)
        {
            //
            /*([strCustomerCode],[strAssetRef],[strAssetRef2],[strAssetRef3],[fltLat],[fltLon],[dteLastVisit],[strAssetName],[PurchOrDate],[strAssetBranding],[strAssetMake]
           ,[strAssetModel],[strAssetSerialNo],[strAssetDescription],[strBase],[strPlacement],[strAssetQty]
           ,[strAssetAddress],[strAssetArea],[strAssetAreaTelephone],[strAssetCellContacts],[strAssetsHoldersContactPeople],[strDateCaptured]
           ,[strCustomerName])
     VALUES
     (@customerCode,@assetName,@ref2,@ref3,@lat,@lon,@lastvisit,@assetName,@purchdate,@branding,@assetmake,@assetmodel,@assetSerialno,@description,@base
         ,@placement,@qty,@address,@area,@tel,@cell,@contanctperson,getdate()
         ,@customername
            */
          /* $return =  DB::connection('linxbriefcase')
                ->select("EXEC spCRUDassets $id,$customerCode,$customerName,$contactPerson,$contacttel,$cellnumber,$area,
                 $placement,$base,$assetname,$status,$serialno,$branding,$model,$make,$purch,$assetlastvisisted,$assettype,$latitude,$longitude,'o',$address,$description,$qty,'Update'");
*/

            $return = DB::connection('linxbriefcase')->table('tblAssets')
                ->where('ID',$id )
                ->update(['strAssetHistory' => $history,'strAssetRef' => $assetname,
                    'strAssetRef3' => $status,'fltLat' => $latitude,
                    'fltLon' => $longitude,
                    'strAssetName' => $assetname,'PurchOrDate' => $purch,
                    'strAssetBranding' => $branding,'strAssetMake' => $make,
                    'strAssetModel' => $model,'strAssetSerialNo' => $serialno,
                    'strAssetDescription' => $description,'strBase' => $base,
                    'strPlacement' => $placement,'strAssetQty' => $qty,
                    'strAssetAddress' => $address,'strAssetArea' => $area,
                    'strAssetAreaTelephone' => $contacttel,'strAssetCellContacts' => $cellnumber,
                    'strAssetsHoldersContactPeople' => $contactPerson,'strCustomerName' => $customerName,
                    'strCustomerCode'=>$customerCode,'strAssetRef2' => $assettype
                ]);
        }else{
            /*$return =  DB::connection('linxbriefcase')
                ->select("EXEC spCRUDassets $id,$customerCode,$customerName,$contactPerson,$contacttel,$cellnumber,$area,
                 $placement,$base,$assetname,$status,$serialno,$branding,$model,$make,$purch,$assetlastvisisted,$assettype,$latitude,$longitude,'0',$address,$description,$qty,'Insert'");

            DB::connection('linxbriefcase')->table('tblAssets')
                ->where('ID',$return[0]->finals )
                ->update(['strAssetHistory' => $history]);*/

            $return =  DB::connection('linxbriefcase')->table('tblAssets')->insertGetId(
                ['strAssetHistory' => $history,'strAssetRef' => $assetname,
                    'strAssetRef3' => $status,'fltLat' => $latitude,
                    'fltLon' => $longitude,
                    'strAssetName' => $assetname,'PurchOrDate' => $purch,
                    'strAssetBranding' => $branding,'strAssetMake' => $make,
                    'strAssetModel' => $model,'strAssetSerialNo' => $serialno,
                    'strAssetDescription' => $description,'strBase' => $base,
                    'strPlacement' => $placement,'strAssetQty' => $qty,
                    'strAssetAddress' => $address,'strAssetArea' => $area,
                    'strAssetAreaTelephone' => $contacttel,'strAssetCellContacts' => $cellnumber,
                    'strAssetsHoldersContactPeople' => $contactPerson,'strCustomerName' => $customerName,
                    'strDateCaptured'=>$captured,'strCustomerCode'=>$customerCode,'strAssetRef2' => $assettype]
            );
        }

        return response()->json($return);
    }
    public function convertUtf8( $value ) {
        return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
    }

    public function syncproducts()
    {
       $returnproducts =  DB::connection('webstore')
            ->select("EXEC spSyncProducts");

        return response()->json($returnproducts);
    }
    public function synccustomers()
    {
        $customers =  DB::connection('webstore')
        ->select("EXEC spSyncCustomers");

        $customersDimsusers =  DB::connection('webstore')
            ->statement("EXEC syncDimsUserToBeWebCustomers");

        return response()->json($customers);
    }
    public function syncorderpattern()
    {
        $orderpattern =  DB::connection('webstore')
            ->select("EXEC spSyncCustmerDefault");

        return response()->json($orderpattern);
    }

    public function syncpricelist()
    {
        $pricelists =  DB::connection('webstore')
            ->select("EXEC spSynPriceLists");

        return response()->json($pricelists);
    }
    public function syncpricelistPrices()
    {
        $pricelists =  DB::connection('webstore')
            ->select("EXEC spSynPriceListLines");

        return response()->json($pricelists);
    }
     public function syncpricelistStock()
    {
        $pricelists =  DB::connection('webstore')
            ->select("EXEC spSyncInstockQuantity");

        return response()->json($pricelists);
    }

    public function syncgroupspecials()
    {
        $groupspecials =  DB::connection('webstore')
            ->select("EXEC spSyncGroupSpecials");

        return response()->json($groupspecials);
    }
    public function synccustomerspecials()
    {
        $customerspecaisl =  DB::connection('webstore')
            ->select("EXEC spSyncCustomerSpecials");

        return response()->json($customerspecaisl);
    }
    public function syncoverallspecials()
    {
        $customerspecaisl =  DB::connection('webstore')
            ->select("EXEC spSyncOverallSpecails");

        return response()->json($customerspecaisl);
    }
    public function getWebstoreFile()
    {
        return view('dims/webstorecustomerfile');
    }
    public function getWebstoreCustomers()
    {
        $webstorecust =  DB::connection('linxbriefcase')
            ->select("select CustomerCode,CustomerStoreName,Email,UserName,CustomerRepresentitiveID from tblDIMSUSERS");

        return response()->json($webstorecust);
    }
    public function notVisitedView()
    {
        return view('dims/notVisited');
    }
    public function updateWebstoremasterFileInfo(Request $request)
    {
        $arrayinfo = $request->get('value');//
        $userId = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $getRouteProducts = DB::connection('sqlsrv4')
            ->select("EXEC spXMLUpdateCustomerWebstoreMasterFile '".$this->toxml($arrayinfo, "xml", array("result"))."',".$userId.",'".$userName."'");
        return response()->json($getRouteProducts);
    }
    public function visitsLog($date1,$date2)
    {
        $orderpattern =  DB::connection('linxbriefcase')
            ->select("EXEC spVisitLog '$date1','$date2'");
        return response()->json($orderpattern);
    }
    public function notVisitedLog($date1,$date2)
    {
        $orderpattern =  DB::connection('linxbriefcase')
        ->select("EXEC spNotVisited '$date1','$date2'");
        return response()->json($orderpattern);
    }
    public function restFullInvoices($month,$year,$customerCode)
    {
        $orderpattern =  DB::connection('sqlsrv3')
            ->select("EXEC spRestFulInvoices ".$month.",".$year.",'".$customerCode."'");

        return response()->json($orderpattern);
    }
    public function DriversheatMap()
    {
        $deldate = (new \DateTime())->format('Y-m-d');
        return view('dims/driversondutybydeldate')->with('deldate',$deldate);
    }
    public function returnDriversOnDutyByDeliveryDate($deliverydate)
    {
        $driversonduty =  DB::connection('sqlsrv3')
            ->select("EXEC spDriversOnDutyByDate '".$deliverydate."'");

        return response()->json($driversonduty);
    }
    public function returnDriversOnDutyByRoutingID($routingId)
    {
        $driversondutyStops=  DB::connection('sqlsrv3')
            ->select("EXEC spDriversOnDutyByRoutingID ".$routingId);

        return response()->json($driversondutyStops);
    }
    public function officemap(){
        $route = DB::connection('sqlsrv3')->table('tblRoutes')->select('Route')->get();
        $ordertypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderType')->get();
        return view('dims/driversmap')->with('routes',$route)->with('ordertypes',$ordertypes);
    }
    public function getLiveDriversInfo(Request $request)
    {
        //[spLiveDriversAppInfo]
        $deldate= $request->get('deldate');
        $routename= $request->get('route');
        $ordertype= $request->get('ordertype');
        $driversondutyStops=  DB::connection('sqlsrv3')
            ->select("EXEC spLiveDriversAppInfo '".$deldate."','".$routename."','".$ordertype."'");

        return response()->json($driversondutyStops);
    }
    public function transferblade()
    {
        return view('dims/transferslist');
    }
    public function transfersstatus()
    {

        $listoftransfers= DB::connection('sqlsrv3')
            ->select("Exec spGetListOfTransfers ");
        return view('dims/transfersstatus')->with('Transfers',$listoftransfers);
    }
    public function getTransfers(Request $request)
    {
        $transferId = $request->get('transferId');
        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spGetTransfer ?",
                array( $transferId));
        return response()->json($returnprinteddoc);
    }
    public function updateCheckedOrNotTrasfers(Request $request)
    {
        $orderdetailId= $request->get('orderdetailId');
       // $status= $request->get('status');
        $returnprinteddoc= DB::connection('sqlsrv3')
            ->statement("Exec spMarkOrderCheckedCredits ?,?",
                array( $orderdetailId,0));
        return response()->json($returnprinteddoc);
    }
    public function checkUnCheckTransfers(Request $request)
    {
        $orderdetailId= $request->get('orderdetailId');
        $status= $request->get('status');
        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spMarkTransfersAsCheckOrNot ?,?",
                array( $orderdetailId,$status));
        return response()->json($returnprinteddoc);
    }

    public function getTransfersJson($statuscredits,$dateTo)
    {

        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spDriversOversAndUndersOnTransfers ?,?",
                array( $statuscredits,$dateTo));
        return response()->json($returnprinteddoc);
    }
    //Get the order details for the merged/not transfers, GE
    public function openorderdetailsformergedtransfers(Request $request)
    {
        $Orderids = $request->get('Orderids');
        $productCode = $request->get('productCode');
       // $Orderids = str_replace(",","','",$Orderids);
       // $Orderids = "'".$Orderids."'";
      //  dd($Orderids);

        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spGetMergedTransferLinesByProduct ?,?",
                array( $Orderids,$productCode));
        return response()->json($returnprinteddoc);
    }
    public function getTransfersJsonbydate($transfersDate)
    {
        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spTransfersListBydate ?",
                array( $transfersDate));
        return response()->json($returnprinteddoc);
    }
    public function getInvoices($from,$to,$customercustomercode)
    {
        //dd($customercustomercode."".$from."".$to);
        $currentDate = \Carbon\Carbon::now();
        $agoDate = $currentDate->subDays($currentDate->dayOfWeek)->subWeek();
        $agoDate = (new \DateTime($agoDate))->format('Y-m-d');
        $currentDate = (new \DateTime($currentDate))->format('Y-m-d');

        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("select * from [viewXposeOrderToWebstore] where  CustomerPastelCode = '$customercustomercode' and DeliveryDate between '$from' and '$to' order by DeliveryDate",
                array( $from,$to,$customercustomercode));
        return response()->json($returnprinteddoc);
    }
    public function returnPDF($invoice)
    {
        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spGetPDFinvoice ?",
                array( $invoice));
        return response()->json($returnprinteddoc);
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
