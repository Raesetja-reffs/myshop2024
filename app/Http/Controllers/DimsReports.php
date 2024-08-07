<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 23/09/2017
 * Time: 03:36 PM
 */

namespace App\Http\Controllers;
use App\Exports\OrdersExport;
use App\Exports\SpecialsExport;
use App\Exports\RoutePlanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Khill\Lavacharts\Lavacharts;
use App\Traits\DimsReportsTrait;

class DimsReports extends Controller
{
    use DimsReportsTrait;

    public function reports()
    {
      //  (new DimsCommon())->clearAllUserLocks();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->get();
        $queryCustomers =DB::connection('sqlsrv3')->table("tblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();
        $pickingTeams =  DB::connection('sqlsrv3')->table('tblPickingTeams')->select('PickingTeamId', 'PickingTeam')->get();
        $unAuthOrders =  DB::connection('sqlsrv3')->table('viewUnAuthorisedOrders')
            ->select('OrderId', 'OrderDate','DeliveryDate','Route', 'OrderValue','CreditLimit','BalanceDue','StoreName', 'CustomerPastelCode','UserName')
            ->orderBy('DeliveryDate', 'desc')->get();

        //dd($getRoutes);
        return view('dims/reports')
            ->with('routesNames',$getRoutes)
            ->with('customers',$queryCustomers)
            ->with('products',$queryProducts)
            ->with('unAuthOrder',$unAuthOrders)
            ->with('pickingTeams',$pickingTeams);
    }
    public function fetchData(Request $request)
    {
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');
        $routeId = $request->get('routeId');

        $array = array();
        if($routeId == null)
        {

            $getRoutes =  DB::connection('sqlsrv3')->select("SELECT Routeid FROM tblRoutes WHERE NotInUse =0");
            $count = 0;
            foreach ($getRoutes as $val)
            {
                $array[$count] = $val->Routeid;
                $count++;
            }


            $routeId = implode(", ", $array);
        }else{
            $routeId = implode(", ", $routeId);
        }
        $awaiting = $request->get('awaiting');
        $invoiced = $request->get('invoiced');
        $implodeInvoiced = $invoiced;
        $implodeAwaiting = $awaiting;
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d');
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');

        $GetData = DB::connection('sqlsrv3')
            ->select("EXEC spOrderListingNotOnRouteSheet '".$dateFrom."','".$dateTo."','".$routeId."','".$implodeInvoiced."','".$implodeAwaiting."'");
        //dd("EXEC spOrderListingNotOnRouteSheet '".$dateFrom."','".$dateTo."','".$routeId."','".$implodeInvoiced."','".$implodeAwaiting."'");
        $output['recordsTotal'] = count($GetData);
        $output['data'] = $GetData;
        $output['recordsFiltered'] = count($GetData);

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }
    public function top30Orders()
    {
        $getTop30 =  DB::connection('sqlsrv3')->table('viewTop30OrdersOnDropDown')->select('StoreName', 'CustomerPastelCode','OrderDate','DeliveryDate', 'Backorder','OrderId')
            ->orderBy('OrderId', 'desc')->get();
        return response()->json($getTop30);

    }
    public function Authorised(Request $request)
    {
        //option

        $orderId = $request->get('orderId');
        $option = $request->get('option');

        DB::connection('sqlsrv3')->table('tblOrders')
            ->where('OrderId',$orderId )
            ->update(['Authorised' => 1]);
        $DocId = $orderId;
        $User = Auth::user()->UserID;
        $printerPath ="\\\\".gethostname();
        $PrintDeliveryNote = 0;
        switch ($option){
            case 1:
                $DocType= 4;
                DB::connection('sqlsrv3')
                    ->statement("EXEC spInsertIntoPrintedDoc ".$DocType.",".$DocId.",".$User.",'".$printerPath."',".$PrintDeliveryNote);
                break;
            case 3:
                $DocType= 1;
                DB::connection('sqlsrv3')
                    ->statement("EXEC spInsertIntoPrintedDoc ".$DocType.",".$DocId.",".$User.",'".$printerPath."',".$PrintDeliveryNote);


        }

    }
    public function topOrdersOfACustomer(Request $request)
    {

        $customerCode = $request->get('custCode');
        $getTop30 =  DB::connection('sqlsrv3')
            ->select("EXEC spCustomerLatestOrders '".$customerCode."'");
        return response()->json($getTop30);
    }
    public function contactDetailsOnOrder(Request $request)
    {
        //
        $OrderID = $request->get('OrderID');
        $GetData = DB::connection('sqlsrv3')
            ->select("EXEC spReturnContactsOfAnOrder ".$OrderID);
        return response()->json($GetData);

    }
    public function quotationLayout()
    {
        return view('dims/quotationprint');
    }
    public function searchcustomerpricing(){
        if (config('app.IS_API_BASED')) {
            
        $queryCustomers = $this->apiGetCustomerData();
        $queryGroups = $this->apiGetGroupData();
            }else{
                
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode')->orderBy('CustomerPastelCode','ASC')->get();
        $queryGroups =DB::connection('sqlsrv3')->table("tblGroups" )->select('GroupId','GroupName','GroupCode')->orderBy('GroupId','ASC')->get();
       
                    }
        return view('dims.priceprinting.index')
        ->with('customers',$queryCustomers)
        ->with('groups',$queryGroups);
    }

    public function getAllCustomerPricesSearch(Request $request){
        $inputCustAccount = $request->get('inputCustAccount');
        if (config('app.IS_API_BASED')) {
            
        $getSpecialsOnParams = $this->apiGetSpecialDefaultPricesData([
            'inputCustAccount'=>$inputCustAccount
        ]);
        }else{
            
        $getSpecialsOnParams = DB::connection('sqlsrv3')
        ->select("EXEC sp_API_R_GetCustomerPricesFromSearchParams ? ",array($inputCustAccount));
                }

        return response()->json($getSpecialsOnParams);
    }

    public function getGroupPricesSearch(Request $request){
        $inputGroupId = $request->get('inputGroupId');
        if (config('app.IS_API_BASED')) {
            $getSpecialsOnParams = $this->apiGetGroupSpecialDefaultPricesData([
                'groupid'=>$inputGroupId
            ]);
        }else{
            
        $getSpecialsOnParams = DB::connection('sqlsrv3')
        ->select("EXEC sp_API_R_GetGroupPricesFromSearchParams ? ",array($inputGroupId));
                }

        return response()->json($getSpecialsOnParams);
    }
    public function pickingSlipManue()
    {
        $GroupId = Auth::user()->GroupId;
        $things = (new SalesForm())->getThings($GroupId,'Allow Call Logger');
        $getsRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->orderBy('Route')
            ->get();
        $getsPickingTeams =  DB::connection('sqlsrv3')->table('tblPickingTeams')->select('PickingTeamId', 'PickingTeam')->orderBy('PickingTeam')
            ->get();
        $getsOrderTypes =  DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId', 'OrderType')
            ->get();
        return view('dims/picking_slip_main')
            ->with('routes',$getsRoutes)
            ->with('orderTypes',$getsOrderTypes)
            ->with('pickingteams',$getsPickingTeams)->with('things',$things);
    }
    public function createBulkpicking(Request $request)
    {
        $orderDetails = $request->get('routes');
        $pickingIDs = $request->get('PickingIDs');
        $orderType = $request->get('orderType');
        $tz = new \DateTimeZone("Africa/Johannesburg");
        $now = new \DateTime("now", $tz);
        $deliverydate = (new \DateTime($request->get('delvDate')))->format('Y-m-d');
        $timestamp = (new \DateTime("now",$tz))->format('Y-m-d H:i:s ');

        for($i=0;$i<count($orderDetails);$i++)
        {
            //echo $orderDetails[$i];
            DB::connection('sqlsrv3')
                ->statement("EXEC spBulkPickingCreate '".$deliverydate."',".$orderDetails[$i].",".$orderType.",'".$timestamp."'");
         //   $this->slackUser($orderType,$orderDetails[$i],$deliverydate);
        }
    }
    public function slackUser($ordertype,$route,$delvirateDate)
    {
        //dd("TEST");
        $url = "https://hooks.slack.com/services/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";
        try {


            $client = new Client();

            $request = $client->post($url, ['body' => json_encode(
                [
                    'text' => 'myapp://myhost/data?OrderType='.$ordertype.'&Route='.$route.'&DeliveryDate='.$delvirateDate.'&userid=2',

                ]
            )]);
        } catch (Exception $e) {
            exit();
        }
        $stream = $request->getBody()->getContents();
        echo $stream;
    }
    public function selectBulkPickingHeader()
    {
        $getBulkPickingHeaders = DB::connection('sqlsrv3')
            ->select("SELECT * FROM viewBulkPickingHeader ORDER BY BulkPickingSlipId DESC");
        return response()->json($getBulkPickingHeaders);
    }
    public function selectBulkBatchPickingHeader()
    {
        $getBulkPickingbatch = DB::connection('sqlsrv3')
            ->select("SELECT Timestamp,BulkPickingSlipId,PrintedStatus FROM fnReturnBulkBatch()");

        return response()->json($getBulkPickingbatch);
    }
    public function bulpickingPerRoutePreview($pickingId)
    {

        $getBulkPickingPerRoute = DB::connection('sqlsrv3')
            ->select("SELECT * FROM viewBulkPickingCalculatedPerRoute WHERE BulkPickingSlipId =$pickingId");
        $getPrinters =  DB::connection('sqlsrv3')->table('tblPrinters')->select('strPrinter', 'ID')->orderBy('ID')
            ->get();

        return view('dims/bulkpickperroute')
            ->with('bulkperroute',$getBulkPickingPerRoute)
            ->with('bulkID',$pickingId)
            ->with('printers',$getPrinters);
    }
    public function pickingbyteam($array,$deldate,$orderType,$routes)
    {
        $GroupId = Auth::user()->GroupId;
        $things = (new SalesForm())->getThings($GroupId,'Allow Call Logger');
        $deldate = (new \DateTime($deldate))->format('Y-m-d');
        //viewBulkPickingByPickingTeam
        if ($orderType  == -99)
        {
            $getBulkPickingPerPickingTeam = DB::connection('sqlsrv3')
                ->select("SELECT * FROM viewBulkPickingByPickingTeam WHERE PickingTeamId IN ($array) and DeliveryDate='$deldate' and RouteId IN($routes) order by PastelCode");
        }else{
            $getBulkPickingPerPickingTeam = DB::connection('sqlsrv3')
                ->select("SELECT * FROM viewBulkPickingByPickingTeam WHERE PickingTeamId IN ($array) and DeliveryDate='$deldate' and RouteId IN($routes) and LateOrder =$orderType order by PastelCode");

        }
        $getPrinters =  DB::connection('sqlsrv3')->table('tblPrinters')->select('strPrinter', 'ID')->orderBy('ID')
            ->get();
        return view('dims/bulkpickingperteam')
            ->with('bulkperteamresults',$getBulkPickingPerPickingTeam)
            ->with('pickingId',$array)
            ->with('deldate',$deldate)
            ->with('ordertype',$orderType)
            ->with('routes',$routes)
            ->with('printers',$getPrinters)->with('things',$things);
    }
    public function getDayTripSheetList(Request $request)
    {
        //
        $deldate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $tripsheets = DB::connection('sqlsrv3')
            ->select("EXEC spGetDayTruckSheetLists '".$deldate."'");

        return response()->json($tripsheets);
    }
    public function LoadLogs($routingId){
        $ConsoleLogs= DB::connection('sqlsrv3')
        ->select("Exec spGetManagementDetailsViaRouteId ".$routingId);
        return view('dims/tripsheetconsole')->with ('consolelogs',$ConsoleLogs);
    }
    public function updateReviewedStatus(Request $request)
    {
    $userAuthID = Auth::user()->UserID;
    $ID =$request->get('ID');
    $Reviewed = $request->get('Reviewed');
     DB::connection('sqlsrv3')
        ->statement('exec spUpdateReviewed ?,?,?',
        array($userAuthID,$ID,$Reviewed));
    }
    public function getTripSheetDetails($routingId)
    {
        $tripsheetDetail = DB::connection('sqlsrv3')
            ->select("select *
	from viewDeliveryINstructionsMultiBrand where DeliveryDateRoutingID =".$routingId." order by DeliverySequence");

        $getDrivingInfo = DB::connection('sqlsrv3')
            ->select("Exec spTruckSheetReprintHeader ".$routingId." ");

        return view('dims/tripsheetDetails')
            ->with('tripsheetDetails',$tripsheetDetail)->with('routingId',$routingId)->with('drivingInfo',$getDrivingInfo);
    }
    public function showTripSheets()
    {
        $sheets = (new \DateTime())->format('Y-m-d');
        return view('dims/tripsheet_list')->with('date',$sheets);
    }
    public function createtripsheetnote()
    {
        $sheets = (new \DateTime())->format('Y-m-d');
        return view('dims/tripsheet_note')->with('date',$sheets);
    }

    public function reprintTripSheet($routingId)
    {
        $userAuthID = Auth::user()->UserID;
        DB::connection('sqlsrv3')->table('tblPrintedDocuments')->insert(
            ['DocumentType' => 7, 'DocId' => $routingId,
                'User' => $userAuthID
            ]);
        echo "PLEASE CHECK YOUR PRINTER !";
    }

    public function getPickingDept()
    {
        $cats = DB::connection('sqlsrv3')
            ->select("select * from tblPickingDepartments");


        $ProductInvcats = DB::connection('sqlsrv4')
            ->select("select  RIGHT('000' + CAST(dbo.tblCategories.MainCatId as nvarchar(5)),3) MainCatId,Category from tblCategories");

        return view('dims/stock_report')
            ->with('cats',$cats)
            ->with('prodCats',$ProductInvcats);
    }
    public function getPickingDeptPalladium()
    {
        $cats = DB::connection('sqlsrv3')
            ->select("select * from tblPickingDepartments");

        return view('dims/stock_report_palladium')
            ->with('cats',$cats)
            ;
    }
    public function getPickingTeamsByDept(Request $request)
    {
        $deptId = $request->get("deptids");
        //dd($deptId);
        $depts = implode(",",$deptId);
        $pickingletters = DB::connection('sqlsrv3')
            ->select("select * from tblPickingTeams where departmentID in ($depts) order by PickingTeam");

        return response()->json($pickingletters);
    }
    public function getPickingTeamsByDeptPalladium(Request $request)
    {
        $deptId = $request->get("deptids");
        //dd($deptId);
        $depts = implode(",",$deptId);
        $pickingletters = DB::connection('sqlsrv3')
            ->select("select * from tblPickingTeams where departmentID in ($depts) order by PickingTeam");

        return response()->json($pickingletters);
    }
    public function getBinLocationByPickingTimes(Request $request)
    {

        $binnumber = $request->get("teams");
        //dd($deptId);
        $binnumberString = implode(",",$binnumber);
        $bins = DB::connection('sqlsrv3')
            ->select("select distinct Binnumber from (
                        select iif(SUBSTRING(Binnumber, 0, charindex('-', Binnumber, 0)) = '',Binnumber,SUBSTRING(Binnumber, 0, charindex('-', Binnumber, 0))) as  Binnumber,Binnumber as fullbin
                  ,PickingTeamId from viewtblProducts where PickingTeamId in ($binnumberString)
                  )l
                  where Binnumber is not null or Binnumber<> ' '
                  order by Binnumber");
        return response()->json($bins);
    }
    public function getProductsCats(Request $request)
    {

    }


    //Palladium
    public function gridResultPalladium(Request $request)
    {
        $teams = $request->get("teams");

        $bin = $request->get("bin");
        $actpriducts = $request->get("actpriducts");
        $status = $request->get("status");

        $teamsString = "'".implode(",", $teams)."'" ;
        $binstring = "'".implode(",", $bin)."'";
        $actpriducts = "'".$actpriducts."'";
       // dd("select * from fnStockSheetGrid($teamsString , $binstring,$actpriducts) ");
       $getproducts = DB::connection('sqlsrv3')
            ->select("select  PastelCode, PastelDescription, Instock, Available, Ordered,Binnumber from fnStockSheetGridPalladium($teamsString , $binstring,$actpriducts)");

        $output['recordsTotal'] = count($getproducts);
        $output['data'] = $getproducts;
        $output['recordsFiltered'] = count($getproducts);

        $output['draw'] = intval($request->input('draw'));
        return $output;
    }
    public function gridResult(Request $request)
    {
        $teams = $request->get("teams");

        $bin = $request->get("bin");
        $actpriducts = $request->get("actpriducts");
        $status = $request->get("status");
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $dateto= (new \DateTime($dateto))->format('Y-m-d');
        $datefrom= (new \DateTime($datefrom))->format('Y-m-d');

        $teamsString = "'".implode(",", $teams)."'" ;
        $binstring = "'".implode(",", $bin)."'";
        $actpriducts = "'".$actpriducts."'";
       // dd("select * from fnStockSheetGrid($teamsString , $binstring,$actpriducts) ");
       $getproducts = DB::connection('sqlsrv3')
            ->select("select  PastelCode, PastelDescription, Instock, Available, Ordered,Binnumber,UnitSize,saleQuantity,counts,Cost from fnStockSheetGrid($teamsString , $binstring,$actpriducts,'$datefrom','$dateto')");

        $output['recordsTotal'] = count($getproducts);
        $output['data'] = $getproducts;
        $output['recordsFiltered'] = count($getproducts);

        $output['draw'] = intval($request->input('draw'));
        return $output;
    }
    public function creditNoteReasonsJSon($dateFrom,$dateTo)
    {
        $creditNote = DB::connection('sqlsrv3')
            ->select("Exec spCreditNotesReport '".$dateFrom."','".$dateTo."'");
        return response()->json($creditNote);
    }

    public function creditNoteReasonsView(){
        return view('dims/creditnote');
    }
    public function dashboardSalesPerformance()
    {
        $dates= (new \DateTime())->format('Y-m-d');
        //$dates= '2019-06-27';
        $sales = DB::connection('sqlsrv3')
            ->select("Exec spTeleSalesPerformance '".$dates."','".$dates."'");
$salesMonthToDate = DB::connection('sqlsrv3')
            ->select("Exec [spTeleSalesValues] '".$dates."','".$dates."'");

        $mainArray =array();
        $valueR = 0;
        foreach($sales as $object) {
            $arrays[0] = $object->UserName;
            $arrays[1] = $object->RandVal;
            $arrays[2] = $object->cLor;
            $arrays[3] = $object->RandVal;
            $valueR = $valueR + $object->RandVal;
            $mainArray[] = $arrays;
        }

        $ewa = new Lavacharts; // See note below for Laravel
        $valueR  = round($valueR,0);
        $finances = $ewa->DataTable();
        $finances->addStringColumn('Infraction')
            ->addNumberColumn('Value')
            ->addRoleColumn('string', 'style')
            ->addRoleColumn('string', 'annotation');
        $finances->addRows($mainArray);

      /*  $finances->addRows([
            ['Finishing',            20, 'green',  '20%'],
            ['Evenness / Roughness', 13, 'orange', '13%'],
            ['Cracking / Damages',   34, 'red',    '34%'],
            ['Jointing / Alignment', 22, 'blue',   '22%']
        ]);*/

        $ewa->ColumnChart('EWA', $finances, [
            'title' => "Sales Graph",
            'legend' => 'none',
            'vAxis' => [
                'title'=>'Sales Value'
            ],
            'height' => 400,
            'width' => 900
        ]);
        return view('dims/salesdashboard',array('lava'=>$ewa,'teledata'=> $sales,'rVal'=>$valueR,'mDate'=>$salesMonthToDate));
    }
    public function getreportLayout()
    {
        return view('dims/dims_report_layout');
    }
     public function getreportAuthBelowMargin()
    {
        return view('dims/rptbelowmargin');
    }
    public function getJsonAuthBelowMargin($datefrom,$dateTo)
    {

        $getRouteProducts =DB::connection('sqlsrv3')
            ->select('exec spMarginAuth ?,?',
                array($datefrom,$dateTo)
            );
        return response()->json($getRouteProducts);
    }
    public function getOrderPlacedAfterCutOff()
    {
        $deldate =  (new \DateTime())->format('Y-m-d');
        return view('dims/rptorders_placed_after_custofftime')->with('date',$deldate);;
    }
    public function getJsonCutOffTime($date)
    {
     //   $date = $request->get('orderdate');
        $getRouteProducts =DB::connection('sqlsrv3')
            ->select('exec spOrdersPlacedAfterCutOffTime ?',
                array($date)
            );
        return response()->json($getRouteProducts);
    }
    public function rptToSeeInTockVsOrders()
    {
        return view('dims/rptstockvsordered');
    }
    public function getJsonSrockVsOrdered($dateFrom,$dateTo,$percentage)
    {
        //   $date = $request->get('orderdate');
        $getRouteProducts =DB::connection('sqlsrv3')
            ->select('exec spStockvsOnOrder ?,?,?',
                array($dateFrom,$dateTo,$percentage)
            );
        return response()->json($getRouteProducts);
    }

    public function outstandingDriversCashoff()
    {
        //
        $tripsheets = DB::connection('sqlsrv3')
            ->select("EXEC spGetOutstandingDriversCashoff");
        return view('dims/outstandingdriverscashoff')->with('outstandingtripsheets',$tripsheets);
    }
    public function printDocs()
    {
        return view('dims/printwithout');
    }
    public function getuseractionsBydate(){
        return view('dims/useractionsbydate');
    }
    public function getAwaitingStock(){
        $this->authorize('isAllowCompanyPermission', ['App\Models\CompanyPermission', 'isallowawaitingproducts']);
        return view('dims/awaitingstockreport');
    }
    public function getAwaitingStockbycustomer(){
        $this->authorize('isAllowCompanyPermission', ['App\Models\CompanyPermission', 'isallowawaitingorders']);
        return view('dims/awaitingstockbycustomer');
    }
    public function jsonawaitingstock(Request $request){

        $shorloadedJasper=  DB::connection('sqlsrv3')
            ->select("EXEC spGetAwaitingStockData 'AllProducts'");

        return response()->json($shorloadedJasper);
    }
    public function backordersandawaiting(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $addressId = $request->get('addressId');
        if (config('app.IS_API_BASED')) {
            $backawaiting = $this->apiBackordersandawaiting([
                'CustCode' => $customerCode,
                'DeliveryAddressId' => $addressId
            ]);
        } else {
            $backawaiting = DB::connection('sqlsrv3')
            ->select('exec spBackOrderAndAwaitingStock ?,?',
                array($customerCode,$addressId)
            );
        }

        return response()->json($backawaiting);
    }
    public function jsonuseractionsbydate(Request $request){

        $from  = (new \DateTime( $request->get('from')))->format('Y-m-d')  ;
        $to  =(new \DateTime( $request->get('to')))->format('Y-m-d');



        if (config('app.IS_API_BASED')) {
            $shorloadedJasper = $this->apiGetUserActionsByDateRange([
                'DateFrom' => $from,
                'DateTo' => $to,
            ]);
            return response($shorloadedJasper);

        }else{
        $shorloadedJasper = DB::connection('sqlsrv3')
            ->select("Exec [sp_API_R_UserActionsByDate] ?,?",array($from,$to));
            return response()->json($shorloadedJasper);
        }
        
    }
    public function jsonawaitingstockorders(Request $request){
        $productId  = $request->get('productId');
//EXEC dbo.spGetAwaitingStockData @strWhichData ='OrdersForAProduct', @intProductId =0
        $shorloadedJasper=  DB::connection('sqlsrv3')
            ->select("EXEC spGetAwaitingStockData 'OrdersForAProduct',".$productId);
        return response()->json($shorloadedJasper);
    }
    public function jsonawaitingstockorderlistbycustomer(Request $request){

        $shorloadedJasper=  DB::connection('sqlsrv3')
            ->select("EXEC spGetAwaitingStockData 'AllOrders'");
        return response()->json($shorloadedJasper);
    }
    public function jsonawaitingstockorderproductsfortheid(Request $request){
        $productId  = $request->get('productId');
//EXEC dbo.spGetAwaitingStockData @strWhichData ='OrdersForAProduct', @intProductId =0
        $shorloadedJasper=  DB::connection('sqlsrv3')
            ->select("EXEC spGetAwaitingStockData 'OrdersForAProduct',".$productId);
        return response()->json($shorloadedJasper);
    }
    public function pricelistview(){

        $pricelist =  DB::connection('sqlsrv3')
            ->select("select * from tblPriceLists order by PriceList");
        //
        return view('dims/pricelistview')->with('pricelist',$pricelist);
    }
    public function getProductsMappedToThePriceList(Request $request){
        $pricelistid  = $request->get('pricelistid');
        $returnproductsandPrices=  DB::connection('sqlsrv3')
            ->select("EXEC spPriceListProducts ".$pricelistid);
        return response()->json($returnproductsandPrices);

    }
    public function exportorder($orderid)
    {
        // return Excel::download(new SpecialsExport(), 'specials.xlsx');
        return (new OrdersExport($orderid))->download('order-'.$orderid.'.xlsx');
    }
    public function exportRoutePlanDetails($routeid,$datefrom,$dateto,$ordertype,$status)
    {
        $from  = (new \DateTime($datefrom))->format('Y-m-d');
        $to  =(new \DateTime($dateto))->format('Y-m-d');

        return (new RoutePlanExport($routeid,$datefrom,$dateto,$ordertype,$status))->download('routeplan.xlsx');
    }

}
