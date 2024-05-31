<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SalesForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Cache;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AuthenticateUsersAndCentralUser;
use App\Traits\DimsCommonTrait;

class DimsCommon extends Controller
{
    use DimsCommonTrait;

    public function __construct()
    {
        $this->middleware(AuthenticateUsersAndCentralUser::class);
    }
    public function getCommonRoutes()
    {
        $activeRoutes = Cache::remember('commonroutes', 22*60, function() {
           return DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();
        });
         return response()->json($activeRoutes);
    }
    public function getDeliveryDate()
    {
        $getDeliveryDates = DB::connection('sqlsrv3')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();
        return response()->json($getDeliveryDates);
    }
    public function printInvoiceNow(Request $request)
    {
        $DocType= $request->get('DocType');
        $DocId = $request->get('DocId');
        $invoiceNumber = $request->get('invoiceNumber');
        $User = Auth::user()->UserID;
        $printerPath =Auth::user()->PrinterPathInvoice;
        $PrintDeliveryNote = $request->get('PrintDeliveryNote');

        if(strlen(trim($invoiceNumber)) < 1)
        {
            $returnStatement = DB::connection('sqlsrv3')
                ->select("EXEC spAssignInvoiceNumber '".$DocId."',". $User);

            $return = DB::connection('sqlsrv3')->table('tblOrders')
                ->select('InvoiceNo')->where('OrderId',$DocId)->get();

            if(strlen($return[0]->InvoiceNo) > 1 )
            {

                $returnStatement = DB::connection('sqlsrv3')
                    ->select("EXEC spAssignInvoiceNumber '".$DocId."',". $User);
                return "Process Passed";
            }
            else{
                return "Process failed";//when gerating the invoice number.
            }


        }else{
            $returnStatement = DB::connection('sqlsrv3')
                ->select("EXEC spAssignInvoiceNumber '".$DocId."',". $User);
            return "Process Passed";
        }
    }
    public function intoTblPrintedDoc(Request $request)
    {

        $DocId = $request->get('DocId');
        $User = Auth::user()->UserID;

        DB::connection('sqlsrv3')
            ->statement("EXEC spReprintPickingSlip ".$DocId.",".$User.",1");
        return $DocId;

    }

    public function intoTblPrintedDocPickingSlips(Request $request)
    {

        $DocId = $request->get('DocId');
        $User = Auth::user()->UserID;

        DB::connection('sqlsrv3')
            ->statement("EXEC spReprintPickingSlip ".$DocId.",".$User.",0");
        return $DocId;

    }
    public function InsertToEmail(Request $request)
    {

        $User = Auth::user()->UserID;


        $DocType= $request->get('DocType');
        $DocId = $request->get('DocId');
        $printerPath ="\\\\".gethostname();

        DB::connection('sqlsrv3')
           ->statement("EXEC spEmailOrder ".$DocId.",".$User);
    }
    public function insertIntoTblPicking(Request $request)
    {
        $pickingteams = $request->get('pickingteams');
        $deldate = $request->get('deldate');
        $ordertype = $request->get('ordertype');
        $routes = $request->get('routes');
        $printerVal = $request->get('printerVal');
        $User = Auth::user()->UserID;
        $DocDateTime = (new \DateTime($deldate))->format('Y-m-d');
        $myArraypTeams = explode(',', $pickingteams);
        $myArraypRoute = explode(',', $routes);

        if ($ordertype != -99)
        {
            for ($r = 0 ;$r < count($myArraypRoute);$r++){
              //  for($p = 0 ;$p<count($myArraypTeams);$p++){
                    DB::connection('sqlsrv3')
                        ->statement("EXEC spInsertIntoPicking 3,".$myArraypTeams[0].",'".$DocDateTime."',".$myArraypRoute[$r].",".$ordertype.",".$User.",".$printerVal);
              //  }

            }
        }
        else {
            $ordertypesName = DB::connection('sqlsrv3')
                ->select("SELECT * FROM tblOrderTypes ");

            foreach($ordertypesName as $val) {

                for ($r = 0; $r < count($myArraypRoute); $r++) {
                    //for ($p = 0; $p < count($myArraypTeams); $p++) {
                        DB::connection('sqlsrv3')
                            ->statement("EXEC spInsertIntoPicking 3," . $myArraypTeams[0] . ",'" . $DocDateTime . "'," . $myArraypRoute[$r] . "," . $val->OrderTypeId . "," . $User . "," . $printerVal);
                   // }

                }
            }
        }
        return "done";
    }
    public function insertIntoTblPickingPerRoute(Request $request)
    {
        $bulkID = $request->get('bulkID');
        $User = Auth::user()->UserID;
        $printerVal = $request->get('printerVal');
        $DocDateTime = "2017-01-01 00:00:00";
        //
        $getRoute =  DB::connection('sqlsrv3')->table('tblBulkPickingSlip_Header')->select('RouteId')
            ->get();

        //dd("EXEC spInsertIntoPicking 1,".$bulkID.",'".$DocDateTime."',".$getRoute[0]->RouteId.",1,".$User.",".$printerVal);
        //ignore the values of other fields,Required= picking id,user id,printer and doc type
                $statement = DB::connection('sqlsrv3')
                    ->statement("EXEC spInsertIntoPicking 1,".$bulkID.",'".$DocDateTime."',".$getRoute[0]->RouteId.",1,".$User.",".$printerVal);
        $result = 'true';
        if ($statement)
        {
            $result ='true';
        }
        else{
            $result ='false';
        }
        return $result;


    }
    public function bulpickingbyBatch($bulkid)
    {
        $User = Auth::user()->UserID;
        //H:m:s

        $printerVal = DB::connection('sqlsrv3')->table('tblPrinters')->select('ID')->find(1);
        $Timestamp = DB::connection('sqlsrv3')->table('tblBulkPickingSlip_Header')->select('Timestamp')->where('BulkPickingSlipId',$bulkid)->get();
        $reultsTimestamp = (new \DateTime($Timestamp[0]->Timestamp))->format('Y-m-d H:m:s');

        //ignore the values of other fields,Required= picking id,user id,printer and doc type
                $statement = DB::connection('sqlsrv3')
                    ->statement("EXEC spInsertIntoPicking 2,11,'".$Timestamp[0]->Timestamp."',111,1,".$User.",".$printerVal->ID);
        return view('dims/batchprinted');

    }
    public function printTruckControlID(Request $request)
    {
        $DocType= $request->get('DocType');
        $DocId = $request->get('DocId');
        $DocId = $request->get('DocId');
        $User = Auth::user()->UserID;
        $printerPath = "\\\\".gethostname();
        $PrintDeliveryNote = 0;
        DB::connection('sqlsrv3')
            ->statement("EXEC spInsertIntoPrintedDoc ".$DocType.",".$DocId.",".$User.",'".$printerPath."',".$PrintDeliveryNote);
    }

    public function dimsAdminUsers()
    {
        $activeRoutes = Cache::remember('dimsUser', 22*60, function() {
            return DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName', 'Password')->where('Administrator', '1')->orderBy('UserName', 'asc')->get();
        });
         return response()->json($activeRoutes);
    }
    public function verifyAuth(Request $request)
    {
        $userNameId = $request->get('userName');
        $userPassword = $request->get('userPassword');
        if (config('app.IS_API_BASED')) {
            $activeUser = $this->apiVerifyAuth([
                'userNameId' => $userNameId,
                'userPassword' => $userPassword,
            ]);
        } else {
            $activeUser = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName','Password')
                ->where('UserName','LIKE',"%{$userNameId}%")->where('Password',$userPassword)->get();
        }

        return response()->json($activeUser);
    }
    public function customerflexgrid(){
        $queryCustomers =DB::connection('sqlsrv3')->table("viewCustomerGrid" )->select('*')->distinct()->get();
        $queryRoutes=DB::connection('sqlsrv3')->table("tblRoutes")->select('Route','RouteId')->distinct()->get();
        $queryGroups=DB::connection('sqlsrv3')->table("tblGroups")->select('GroupId','GroupName')->distinct()->get();
        $querySalesMen=DB::connection('sqlsrv3')->table("tblDIMSUSERS")->select('UserName', 'strSalesmanCode')->distinct()->get();
        $queryUsers=DB::connection('sqlsrv3')->table("tblDIMSUSERS")->select('UserName', 'UserID')->distinct()->get();
                return view('dims/customergridwithflex')->with('routes',$queryCustomers)->with('routesonly', $queryRoutes)
                ->with('groups',$queryGroups)->with('salesmen',$querySalesMen)->with('users',$queryUsers);
    }

    public function updateCustomerGrid(Request $request){

        $Userid = Auth::user()->UserID;
        $User= Auth::user()->UserName;
        $customerid = $request->get('customerid');
        $route = $request->get('route');
        $email= $request->get('email');
        $contactperson = $request->get('contactperson');
        $contactno  = $request->get('contactno');
        $groupname = $request->get('groupname');
        $salesrep = $request->get('salesrep');
        $deliveryseq = $request->get('deliveryseq');
        $receivesemail = $request->get('receivesemail');
        $uniquedel = $request->get('uniquedel');
        $priocust = $request->get('priocust');
        $onhold = $request->get('onhold');
        $markupperc = $request->get('markupperc');
		$selecteduser = $request->get('selecteduser');
		$deladd1 = $request->get('deladd1');
		$deladd2 = $request->get('deladd2');
		$deladd3 = $request->get('deladd3');
		$deladd4 = $request->get('deladd4');
		$deladd5 = $request->get('deladd5');


        DB::connection('sqlsrv3')
        ->statement('exec spUpdateCustomerGrid ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
        array($Userid,$User,$customerid,$route,$email,$contactperson,$contactno
    ,$groupname,$salesrep,$deliveryseq,$receivesemail,$uniquedel,$priocust,$onhold,$markupperc,
	$selecteduser,$deladd1,$deladd2,$deladd3,$deladd4,$deladd5));

    }
    public function verifyAuthOnAdmin(Request $request)
    {
        $v  =  new \App\Http\Controllers\SalesForm();
        $userNameId = $request->get('userName');
        $userPassword = $request->get('userPassword');
        $hasauthPrices = $v->getThings(Auth::user()->GroupId,'Access To Auth Prices');
       // dd();
        $activeUser = "";
        if($hasauthPrices =="1"){
            $activeUser= DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName','Password')
                ->where('UserName','LIKE',"%{$userNameId}%")->where('Password',$userPassword)->get();
        }


        return response()->json($activeUser);
    }
    /****THIS SHOULD BECOME AUTH *******************************************/
    public function verifyAuthCreditors(Request $request)
    {
        $userNameId = $request->get('userName');
        $userPassword = $request->get('userPassword');
        $OrderId= $request->get('OrderId');

        $v  =  new \App\Http\Controllers\SalesForm();

        $activeUser= DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('GroupId','UserID', 'UserName','Password')
            ->where('UserName',$userNameId)->where('Password',$userPassword)->get();
        $hasAccess = "Sorry ,you don't have access to authorize accounts";
    //    dd($activeUser);
        if(count($activeUser) > 0)
        {
            $things = $v->getThings($activeUser[0]->GroupId,'Auth on customer hold');
            if($things != "0")
            {
                DB::connection('sqlsrv3')
                    ->statement("Exec spAuthorisePickingLoading ".$OrderId.",1,1");
                $hasAccess = "DONE";
            }
        }
        $output['done'] = $hasAccess;
        $output['result'] = $activeUser;
        return response()->json($output);
    }
    public function checkifhasmultiaddress(Request $request)
    {
        $customerCode = $request->get('account');
        if (config('app.IS_API_BASED')) {
            $hasmulti = $this->apiCheckifhasmultiaddress([
                'customerCode' => $customerCode
            ]);
        } else {
            $hasmulti = DB::connection('sqlsrv3')
                ->select("Exec spHasMultiDeliveryAddress '".$customerCode."'");
        }

        return response()->json($hasmulti);
    }
    public function AuthBulkZeroCost(Request $request)
    {
        $userNameId = $request->get('userName');
        $userPassword = $request->get('userPassword');
        $OrderId= $request->get('OrderId');

        $v  =  new \App\Http\Controllers\SalesForm();

        $activeUser= DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('GroupId','UserID', 'UserName','Password')
            ->where('UserName',$userNameId)->where('Password',$userPassword)->get();
        $hasAccess = "Sorry ,you don't have access to authorize accounts";
    //    dd($activeUser);
        if(count($activeUser) > 0)
        {
            $things = $v->getThings($activeUser[0]->GroupId,'Auth Zero Cost');
            if($things != "0")
            {
                DB::connection('sqlsrv3')->table('tblOrderDetails')
                    ->where('OrderId', $OrderId)
                    ->update(['blnCostAuth' =>1]);
                $hasAccess = "DONE";
            }
        }
        $output['done'] = $hasAccess;
        $output['result'] = $activeUser;
        return response()->json($output);
    }
    public function AuthExternaOrders(Request $request)
    {
        $userName = $request->get('userName');
        $userPassword = $request->get('userPassword');
        $type = $request->get('type');
        $ID = $request->get('ID');
        $code = $request->get('code');

        $things = 0;
        $auth=  DB::connection('sqlsrv3')
            ->select("Exec spAuthExternal ?,?,? ",
                array($userName,$userPassword,$type)
            );
        foreach ($auth as $val)
        {
            $things =  $val->results;
           // dd($things);
        }
        $return = 0;
        if($things == 1)
        {
           //auth linxbriefcase
          //  dd($ID."==".$code);
            $return =  DB::connection('linxbriefcase')->table('OrderLines')->where('ID', $ID)->where('strPartNumber',$code)->where('Authorised',1)->update(['Authorised' => 0]);
        }
       // dd($return);
        return $return;

    }
    public function verifyAuthGroupLeaders(Request $request)
    {
        $userNameId = $request->get('userName');
        $userPassword = $request->get('userPassword');



            $activeUser= DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName','Password','GroupId')
                ->where('UserName','LIKE',"%{$userNameId}%")->where('Password',$userPassword)->first();
        $things = (new SalesForm())->getThings($activeUser->GroupId,'Margin');

           if($things != 0)
           {
               $activeUser= DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName','Password','GroupId')
                   ->where('UserName','LIKE',"%{$userNameId}%")->where('Password',$userPassword)->get();
           }else{
               $activeUser= DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName','Password','GroupId')
                   ->where('UserName','LIKE',"%{$userNameId}%")->where('Password',$userPassword)->where('GroupId',99999999999999999)->get();
           }
            return response()->json($activeUser);

    }
    public function verifyAuthOnAdminMargin(Request $request)
    {
        $userNameId = $request->get('userName');
        $userPassword = $request->get('userPassword');
        $orderId = $request->get('orderId');
        $activeUser= DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName','Password')
            ->where('UserName','LIKE',"%{$userNameId}%")->where('Password',$userPassword)->get();

        if (!empty($activeUser))
        {
            DB::connection('sqlsrv3')->table('tblOrders')
                ->where('OrderId',$orderId )
                ->update(['Authorised' => 1]);
        }
        return response()->json($activeUser);
    }
    public function lockOrder($orderID)
    {
        $userId =   Auth::user()->UserID;

        if(env("DEPARTMENT_LOCKING")  !='TRUE')
        {
        DB::connection('sqlsrv3')->table('tblOrderLocks')->insert(
            ['OrderId' => $orderID, 'UserId' => $userId]
        );
        }else{
            DB::connection('sqlsrv3')->table('tblOrderLocksByDepartment')->insert(
                ['intOrderID' => $orderID, 'intUserId' => $userId,'strDepartment'=>'SALES']
            );
        }

    }
    public function stocktakecountspage(){
        $getAllStockCounts = DB::connection('sqlsrv3')
        ->select('SELECT * FROM vwStockTakeCountsGrid' );

        return view('dims/stock_take_counts_grid')
            ->with('stocks',$getAllStockCounts);

    }
    public function grvgridpage(){
        $grvs = DB::connection('sqlsrv3')
        ->select('exec [spGetPOforVendorGrid]' );

        return view('dims/grv_post_grid')
            ->with('grvs',$grvs);
    }
    public function stocktakegrid(){

        return view ('dims/stocktakegrid');
    }
    public function savestocktakename(Request $request){

        $stocktakename=$request->get('stocktakename');

         DB::connection('sqlsrv2')->statement("Exec spInsertStocktakeName ?",array($stocktakename));

    }
    public function getStockTakeName(Request $request){
        $datefrom= $request->get('datefrom');
        $dateto = $request->get('dateto');

        $stocktakes = DB::connection('sqlsrv2')
        ->select('exec spListStockTakes ?,?',
            array($datefrom,$dateto));
    return response()->json($stocktakes);
    }
    public function selectStockTake(Request $request){
        $strStockTakeName= $request->get('strStockTakeName');

        $stocktakes = DB::connection('sqlsrv2')
        ->select('exec spGetStockTakeOnName ?',
            array($strStockTakeName));
    return response()->json($stocktakes);
    }
    public function getStockTakeNameLines(Request $request){
        $strStockTakeName= $request->get('stocktakename');

        $stocktakes = DB::connection('sqlsrv2')
        ->select('exec spStockTakeCountsLineblade ?',
            array($strStockTakeName));
    return response()->json($stocktakes);
    }
    public function updateStockTakeOnSelector(Request $request){

        $status= $request->get('status');
        $stocktakeid= $request->get('stocktakeid');
        DB::connection('sqlsrv2')
        ->statement('exec spUpdateStockTakeStatus ?,?',
            array($stocktakeid,$status));
    }
    public function getPoLineGrid(Request $request){
        $ponumber = $request->get('PODOC');
        $lines = DB::connection('sqlsrv3')
        ->select('exec spGetPurchaseOrderLines ?',array($ponumber));
        return response()->json($lines);
    }
    public function deleteuserOrderLocks()
    {
        $userId =   Auth::user()->UserID;
        if(env("DEPARTMENT_LOCKING")  !='TRUE') {
            DB::connection('sqlsrv3')->table('tblOrderLocks')->where('UserId', $userId)->delete();
        }else{
            DB::connection('sqlsrv3')->table('tblOrderLocksByDepartment')->where('intUserId', $userId)->delete();
        }
        DB::connection('sqlsrv3')->table('tblOrderLocks')->where('UserId', $userId)->delete();
    }
    public function updateallOrderlinestocostauth(Request $request)
    {
        $OrderId = $request->get('orderId');
        DB::connection('sqlsrv3')->table('tblOrderDetails')
            ->where('OrderId', $OrderId)
            ->update(['blnCostAuth' =>1]);
    }

    public function restFullOrderLock(Request $request)
    {
        $orderID = $request->get('orderID');
        $userId =   Auth::user()->UserID;
        $responseFromOrdeLock = $this->checkUserLock($orderID);

        if($responseFromOrdeLock[0]->orderID == "inserted")
        {
            /*DB::connection('sqlsrv3')->table('tblOrderLocks')->insert(
                ['OrderId' => $orderID, 'UserId' => $userId]
            );*/
            return "Inserted";
        }
        else{

            return $responseFromOrdeLock[0]->orderID;
        }

    }
    public function unLockOrder($orderID)
    {
        DB::connection('sqlsrv3')->table('tblOrderLocks')->where('OrderId', $orderID)->delete();
    }
    public function restFullUnLockOrder($orderID)
    {
        DB::connection('sqlsrv3')->table('tblOrderLocks')->where('OrderId', $orderID)->delete();
    }
    public function clearAllUserLocks()
    {
        //Auth
        $userId = Auth::user()->UserID;
        DB::connection('sqlsrv3')->table('tblOrderLocks')->where('UserId', $userId)->delete();
    }
    public function checkUserLock($OrderId)
    {
        $userId = Auth::user()->UserID;
         $CheckOrderLocks = DB::connection('sqlsrv3')
             ->select("EXEC spOrderLocks '".$OrderId."',".$userId);
         return $CheckOrderLocks;
    }

    public function invoiceLookUp(Request $request)
    {
        $results = [];
        $term = $request->get('term', '');
        if (config('app.IS_API_BASED')) {
            $results = $this->apiGetInvoiceLookup($term);
        } else {
            $queries = DB::connection('sqlsrv3')->table("vwInvoiceOrderIDLookUp")
                ->where('InvoiceNo', 'LIKE', '%'.$term.'%')
                /* ->orWhere('OrderId', 'LIKE', '%'.$term.'%')
                ->orWhere('CustomerPastelCode', 'LIKE', '%'.$term.'%')
                ->orWhere('StoreName', 'LIKE', '%'.$term.'%')*/
                ->take(10)->get();
            if ($queries) {
                foreach ($queries as $query) {
                    $results[] = [
                        'id' => $query->OrderId,
                        'value' => $query->InvoiceNo,
                        'StoreName' => $query->StoreName,
                        'CustomerPastelCode' => $query->CustomerPastelCode,
                        'CompanyName' => $query->CompanyName,
                        'mnyTotal' => $query->mnyTotal,
                        'PaymentTerms' => $query->PaymentTerms
                    ];
                }
            }
        }
        if (empty($results)) {
            $results = ['value'=>'No Result Found','id'=>''];
        }

        return $results;
    }
    public function customerLookUp(Request $request)
    {
        $term = $request->get('term','');;

        $results = array();
        $queries =DB::connection('sqlsrv3')->table("viewtblCustomers")
            ->where('StoreName', 'LIKE', '%'.$term.'%')
            ->take(10)->get();
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->CustomerId, 'value' => $query->StoreName,'StoreName'=>$query->StoreName,'CustomerPastelCode'=>$query->CustomerPastelCode];
        }
        if(count($results))
            return $results;
        else
            return ['value'=>'No Result Found','id'=>''];
    }
    public function marginControl()
    {
        $marginType =  DB::connection('sqlsrv3')->table('tblCOMPANYREPORTS')->select('ReportType', 'Comment')->where('ReportName','marginCalculator')
            ->where('Function','1')
            ->get();
        return response()->json($marginType);
    }
    //True or False
    public function blnCompanyReports()
    {
        $trueFalse =  DB::connection('sqlsrv3')->table('tblCOMPANYREPORTS')->select('ReportType', 'ReportName')->where('ReportName','True')
            ->orwhere('ReportName','False')
            ->get();
        return response()->json($trueFalse);
    }
    public function communications(Request $request)
    {
        $customerCode = $request->get('CustomerCode');
        $subject = $request->get('Subject');
        $body = $request->get('Body');
        $type= $request->get('Type');
        $message =  DB::connection('sqlsrv3')
            ->statement("EXEC spInsertIntoTblCommunications '".$subject."','".$body."','".$type."','".$customerCode."'");
        return response()->json($message);
    }
    public function invoicedoc(Request $request)
    {
        $OrderId = $request->get('OrderId');
        if (config('app.IS_API_BASED')) {
            $this->apiInvoicedoc([
                'OrderId' => $OrderId
            ]);
        } else {
            $userID = Auth::user()->UserID;
            $v = new \App\Http\Controllers\SalesForm();
            $hasauthInvoicePrinting = $v->getThings(Auth::user()->GroupId,'Print Invoice');
            if ($hasauthInvoicePrinting == "1"){
               $return = DB::connection('sqlsrv3')
                    ->statement("EXEC spPrintInvoice  ".$OrderId.",".$userID);
            }
        }

        return response()->json($OrderId);
    }

    public function getDataFromManagementConsole(Request $request)
    {
        $docId = $request->get('orderID');
        $data =  DB::connection('sqlsrv3')
            ->select("EXEC spManagementConsoleData ".$docId);

        $output['recordsTotal'] = count($data);
        $output['data'] = $data;
        $output['recordsFiltered'] = count($data);

        $output['draw'] = intval($request->input('draw'));
        return $output;

    }
    public function getDataFromManagementConsoleForAuditors(Request $request)
    {
        $order = $request->get('order');
        $product = $request->get('product');
        $customer = $request->get('customer');
        if(is_int($order + 0))
        {
            //dd("EXEC spManagementConsoleDataAudit '".strval($order)."','".$product."','".$customer."'");
            $data =  DB::connection('sqlsrv3')
                ->select("EXEC spManagementConsoleDataAudit '".strval($order)."','".$product."','".$customer."'");
        }else{
            $getOrderId = DB::connection('sqlsrv3')->table('tblOrder')->select('OrderId')->where('InvoiceNo',$order)->get();
            if(count($getOrderId) > 0) {
                $data = DB::connection('sqlsrv3')
                    ->select("EXEC spManagementConsoleDataAudit '" . $getOrderId[0]->OrderId . "','" . $product . "','" . $customer . "'");
            }else{
                $data = DB::connection('sqlsrv3')
                    ->select("EXEC spManagementConsoleDataAudit '" . strval($order) . "','" . $product . "','" . $customer . "'");

            }
        }


        $output['recordsTotal'] = count($data);
        $output['data'] = $data;
        $output['recordsFiltered'] = count($data);

        $output['draw'] = intval($request->input('draw'));
        return $output;

    }
    public function simpleOrderUpdate($orderID,$message,$orderNumber,$awaitingStock)
    {
        /*
         *  @orderID as integer,
            @message as nvarchar(500),
            @orderNo as nvarchar(50),
            @awaitingStock as integer
         */
        $simpleUpdate= DB::connection('sqlsrv3')
            ->statement("EXEC spSimpleOrderHeaderUpdateByOrderId ".$orderID.",'".$message."','".$orderNumber."',".$awaitingStock);
    }
    public function assignRouteToTheCustomer(Request $request)
    {
        $custCode = $request->get('custCode');
        $routeId = $request->get('routeId');
         DB::connection('sqlsrv3')
            ->statement("EXEC spassignNewRouteToTheCustomer '".$custCode."',".$routeId);
    }
    public function credentialsmatch(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $match = "match";
         $count = DB::connection('sqlsrv3')
            ->select("EXEC spMatchCredentials '".$username."','".$password."'");
         if(count($count) > 0)
         {
             $match = "match";
         }else{
             $match = "no";
         }
         return $match;
    }
    public function getAvailable(Request $request)
    {
        $prodcode = $request->get('prodcode');


        $getAvailable = DB::connection('sqlsrv3')
            ->select("EXEC spGetAvailable '".$prodcode."'");

        if(count($getAvailable) > 0)
        {

            return $getAvailable[0]->available;
        }else{

            return 0;
        }

    }
    public function massCustomer()
    {

        return view('dims/mass_customer');

    }
    public function managementSearch()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("vwTestTblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder','UnitWeight','SoldByWeight','strBulkUnit')->distinct()->orderBy('PastelDescription','ASC')->get();
        $consoleTypes =  DB::connection('sqlsrv3')
            ->select("SELECT * FROM tblDIMSConsoleTypes Order by strConsoleTypes");

        return view('dims/management_console')->with('customers',$queryCustomers)
            ->with('products',$queryProducts)->with('consoles',$consoleTypes);

    }
    public function masscustomerdatatable(Request $request){
        $userid =Auth::user()->UserID;
        $massCustomer = DB::connection('sqlsrv3')

            ->select("SELECT * FROM viewtblCustomers inner join tblAccessOnCustomers on
                        tblAccessOnCustomers.intGroupId = viewtblCustomers.GroupId
                         where intUserId = $userid and StatusId = 1 Order by StoreName");
        $output['recordsTotal'] = count($massCustomer);
        $output['data'] = $massCustomer;
        $output['recordsFiltered'] = $output['recordsTotal'];

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }
    public function massCustomerUpdate($customerId)
    {
        $massCustomerUpdate = DB::connection('sqlsrv3')
            ->select("SELECT * FROM viewtblCustomers where CustomerId = $customerId");
        $priceList= DB::connection('sqlsrv3')
            ->select("select PriceListId,PriceList from tblPriceLists");
        $selectUsers = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName')->orderBy('UserName', 'asc')->get();
        return view('dims/mass_customer_update')
            ->with('custInfo',$massCustomerUpdate)
            ->with('priceLists',$priceList)
            ->with('dimsusers',$selectUsers)
            ->with('customerId',$customerId);
    }
    public function customerorderpattern($customerId)
    {
        $selectCustomers = DB::connection('sqlsrv3')->table('viewtblCustomers')->select('CustomerPastelCode')->where('CustomerId',$customerId)->get();
        $customerCode = $selectCustomers[0]->CustomerPastelCode;
        $orderpattern = DB::connection('sqlsrv3')
            ->select("SELECT * FROM fnCustomerDefaultOrders('$customerCode',0,0) order by PastelDescription");

        return view('dims/customer_order_pattern')
            ->with('order_pattern',$orderpattern);
    }
    public function deletepatternline(Request $request)
    {
        $defaultID= $request->get('defaultID');
        //
        DB::connection('sqlsrv3')->table('tblCustomerDefaultOrders')
            ->where('ID',$defaultID )
            ->delete();
        return $defaultID;
    }
    public function customerOrderListingHeader(Request $request)
    {
        //spOrderListingCustomerReport
        $customerID= $request->get('customerID');
        $dateFrom= (new \DateTime($request->get('dateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('dateTo')))->format('Y-m-d');
        $customerOrderListingheader = DB::connection('sqlsrv3')
            ->select("EXEC spOrderListingCustomerReport ".$customerID.",'".$dateFrom."','".$dateTo."'");


        $output['recordsTotal'] = count($customerOrderListingheader);
        $output['data'] = $customerOrderListingheader;
        $output['recordsFiltered'] = $output['recordsTotal'];

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }
    public function updatebasicinfo(Request $request)
    {
        $hiddenCustomerID= $request->get('hiddenCustomerID');
        $route= $request->get('route');
        $status= $request->get('status');
        $salesrep= $request->get('salesrep');
        $currentgp= $request->get('currentgp');
        DB::connection('sqlsrv3')->table('tblCustomers')
            ->where('CustomerId',$hiddenCustomerID )
            ->update(['Routeid' => $route,'StatusId'=>$status,'UserID'=>$salesrep,'mnyCustomerGp'=>$currentgp]);

        //to be revisited
        return response()->json(1);

    }
    public function updateContactInfo(Request $request)
    {
        $hiddenCustomerID= $request->get('hiddenCustomerID');
        $ContactTel = $request->get('ContactTel');
        $CellPhone = $request->get('CellPhone');
        $ContactFax = $request->get('ContactFax');
        $ContactPerson = $request->get('ContactPerson');
        $Email = $request->get('Email');
        $strDriversAppEmail = $request->get('strDriversAppEmail');
        DB::connection('sqlsrv3')->table('tblCustomers')
            ->where('CustomerId',$hiddenCustomerID )
            ->update(['BuyerContact' => $CellPhone,'ContactFax'=>$ContactFax,'BuyerTelephone' => $ContactTel,'Email'=>$Email,'ContactPerson'=>$ContactPerson,'strDriversAppEmail'=>$strDriversAppEmail]);

        //to be revisited
        return response()->json(1);

    }
    public function updatePayments(Request $request)
    {
        $hiddenCustomerID= $request->get('hiddenCustomerID');
        $pricelist = $request->get('pricelist');
        $creditlimit = $request->get('creditlimit');
        $pTerms = $request->get('pTerms');

        DB::connection('sqlsrv3')->table('tblCustomers')
            ->where('CustomerId',$hiddenCustomerID )
            ->update(['PriceListId' => $pricelist,'CreditLimit'=>$creditlimit,'strPaymentTerm'=>$pTerms]);

        //to be revisited
        return response()->json(1);

    }
    public function updateDelvAdress(Request $request)
    {
        $hiddenCustomerID= $request->get('hiddenCustomerID');
        $differentDelv = $request->get('differentDelv');

        DB::connection('sqlsrv3')->table('tblCustomers')
            ->where('CustomerId',$hiddenCustomerID )
            ->update(['UniqueDelivery' => $differentDelv]);

        //to be revisited
        return response()->json(1);

    }
    /*****
     * PRODUCT DEPT
     */

    public function massproductdatatable(Request $request){
        $userid = Auth::user()->UserID;
        /*$massProduct = DB::connection('sqlsrv3')
            ->select("SELECT * FROM viewtblProductsAndsalesQuantity where StatusId = 1");*/
        //spMassProducts
        $massProduct = DB::connection('sqlsrv3')
            ->select("EXEC spMassProducts ".$userid);
        $output['recordsTotal'] = count($massProduct);
        $output['data'] = $massProduct;
        $output['recordsFiltered'] = $output['recordsTotal'];

        $output['draw'] = intval($request->input('draw'));

        return $output;
    }

    public function productOnPush($customerId)
    {
        $GetCustomerPushProducts = [];
        $customers = [];
        if ($customerId == 0) {
            $customers = DB::connection('sqlsrv3')->table("viewCustomerGrid" )->select('*')->distinct()->get();
        } else {
            $GetCustomerPushProducts = DB::connection('sqlsrv3')
                ->select("EXEC spProductsOnPush ".$customerId);
        }

        $getAllProducts =  DB::connection('sqlsrv3')
            //->select("SELECT PastelCode,PastelDescription,ProductId FROM viewtblProductsAndsalesQuantity where StatusId = 1 Order by PastelDescription OFFSET 0 ROWS FETCH FIRST 100 ROWS ONLY;");
            ->select("SELECT PastelCode,PastelDescription,ProductId FROM viewtblProductsAndsalesQuantity where StatusId = 1 Order by PastelDescription");

        return view('dims/product_on_push')
            ->with('allProducts',$getAllProducts)
            ->with('customerId',$customerId)
            ->with('pushProducts',$GetCustomerPushProducts)
            ->with('customers',$customers);

    }

    public function insertIntoPushProducts(Request $request)
    {
        $customerId = $request->get('customerId');
        $productsAll = $request->get('productsAll');
        $selectedCustomers = $request->get('selectedCustomers');

        $insertEntries = [];
        if ($customerId == 0) {
            foreach ($selectedCustomers as $val) {
                foreach ($productsAll as $productId) {
                    $insertEntries[] = ['CustomerId' => $val, 'ProductId' => $productId];
                }
            }
        } else {
            foreach ($productsAll as $productId) {
                $insertEntries[] = ['CustomerId' => $customerId, 'ProductId' => $productId];
            }
        }
        if (!empty($insertEntries)) {
            DB::connection('sqlsrv3')->table('tblProduct_Push')->insert($insertEntries);
        }

        return response()->json(1);

    }
    public function insertIntoProhibitProducts(Request $request)
    {
        $customerId = $request->get('customerId');
        $productsAll = $request->get('productsAll');

        for($i = 0;$i < count($productsAll) ;$i++)
        {
            DB::connection('sqlsrv3')->table('tblProduct_Prohibit')->insert(
                ['CustomerId' => $customerId, 'ProductId' => $productsAll[$i]]
            );
        }
        return response()->json(1);

    }
    public function removePushProducts(Request $request)
    {
        $customerId = $request->get('customerId');
        $productsAll = $request->get('productOnPush');
        for($i = 0;$i < count($productsAll) ;$i++)
        {
            DB::connection('sqlsrv3')->table('tblProduct_Push')
                ->where('CustomerId',$customerId )
                ->where('ProductId',$productsAll[$i] )
                ->delete();
        }
        return response()->json(1);

    }
    public function removeProhibitProducts(Request $request)
    {
        $customerId = $request->get('customerId');
        $productsAll = $request->get('productOnPush');
        for($i = 0;$i < count($productsAll) ;$i++)
        {
            DB::connection('sqlsrv3')->table('tblProduct_Prohibit')
                ->where('CustomerId',$customerId )
                ->where('ProductId',$productsAll[$i] )
                ->delete();
        }
        return response()->json(1);

    }
    public function productOnprohibit($customerId)
    {
        $GetCustomerPushProducts = DB::connection('sqlsrv3')
            ->select("EXEC spProductsOnProhibit ".$customerId);

        $getAllProducts =  DB::connection('sqlsrv3')
            ->select("SELECT PastelCode,PastelDescription,ProductId FROM viewtblProductsAndsalesQuantity where StatusId = 1 Order by PastelDescription");

        return view('dims/products_on_prohibit')
            ->with('allProducts',$getAllProducts)
            ->with('customerId',$customerId)
            ->with('pushProducts',$GetCustomerPushProducts);
    }
    public function checkifcustomerspecials($date1,$date2)
    {
        $spceials = DB::connection('sqlsrv3')
            ->select("EXEC spCheckSpecials '".$date1."','".$date2."'");
        return response()->json($spceials);
    }
    public function getcheckifcustomerspecials()
    {
        return view('dims/listofcustomerspecials');
    }
    public function clearorderlocksperorder(Request $request)
    {
        $orderid = $request->get('OrderId');
        if (config('app.IS_API_BASED')) {
            $this->apiClearorderlocksperorder([
                'orderid' => $orderid
            ]);
        } else {
            $userId = Auth::user()->UserID;
            $deleteorderlock = DB::connection('sqlsrv3')
                ->statement("EXEC spDeleteOrderLocksPerUser ".$userId.",".$orderid);
        }
    }
    public function specials()
    {
        //
        $sessionUserId = Auth::user()->UserID;
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )
            ->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')
            ->where('StatusId',1)

            ->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )
            ->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder')->orderBy('PastelDescription','ASC')->distinct()->get();

        return view('dims/specials')
                ->with('products',$queryProducts)
                ->with('customers',$queryCustomers);
    }
    public function doneextending(Request $request)
    {
       $customerId = $request->get('customerId');
         /*//$dateFrom = $request->get('dateFrom');
        $date = (new \DateTime($request->get('dates')))->format('Y-m-d');
        DB::connection('sqlsrv3')->table('tblCustomerSpecials')
            ->where('CustomerId',$customerId )
            ->update(['DateTo' => $date]);*/
        $griddetails = $request->get('griddetails');//


        $gridxml = $this->toxml($griddetails, "xml", array("result"));
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $getResult = DB::connection('sqlsrv4')
            ->statement("EXEC spXMLExtendSelectedCustomerSpecials'" . $gridxml . "','" . $userName . "'," . $userid.",".$customerId);

    }
    public function doneextendinggroupspecials(Request $request)
    {
        $griddetails = $request->get('griddetails');//
        $groupid = $request->get('groupId');//

        $gridxml = $this->toxml($griddetails, "xml", array("result"));
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $getResult = DB::connection('sqlsrv4')
            ->statement("EXEC spXMLExtendSelectedSpecials'" . $gridxml . "','" . $userName . "'," . $userid.",".$groupid);
    }

    public function overallspecials()
    {
        $this->authorize('isAllowCompanyPermission', ['App\Models\CompanyPermission', 'isallowoverallspecials']);
        //
        $queryCustomers =DB::connection('sqlsrv3')->table("vwTestTblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder')->orderBy('PastelDescription','ASC')->distinct()->get();
        $strOverallSpecialType =DB::connection('sqlsrv3')->table("tblOverallSpecialTypes" )->select('intOverallSpecialTypeId','strOverallSpecialType')->orderBy('intOverallSpecialTypeId','ASC')->get();
        $locations = DB::connection('sqlsrv3')->select("select * from tblLocations");
        return view('dims/overallspecial/index')
                ->with('products',$queryProducts)
                ->with('overallspecialtypes',$strOverallSpecialType)->with('locations',$locations)
                ->with('customers',$queryCustomers);
    }
    public function combospecials(){
        $queryProducts =DB::connection('sqlsrv3')->table("viewtblProducts" )->select('ProductId','PastelDescription','PastelCode')->orderBy('PastelCode','ASC')->get();
        return view('dims/poscombospecials')->with('products',$queryProducts);
    }
    public function combospecialsjson(Request $request){
        $datefrom = $request->get('dateFrom');
        $dateto = $request->get('dateTo');
        $getResult = DB::connection('sqlsrv4')
            ->select("EXEC spGetComboSpecialsHeader'" . $datefrom . "','" . $dateto . "'");
        return response()->json($getResult);
    }
    public function xmlSaveComboHeaders(Request $request){
        $comboheader = $request->get('conmboheaders');
        //$orderDetailsxml = $this->toxml($comboheader, "xml", array("result"));
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $getResult = DB::connection('sqlsrv4')
            ->select("EXEC spxmlInsertComboHeaders'" .$comboheader. "','". $userName . "'," . $userid);
        return response()->json($getResult);
    }
    public function xmlSaveComboLines(Request $request){
        $conmboLines = $request->get('conmboLines');
        $comboHeaderID = $request->get('comboHeaderID');
        //$orderDetailsxml = $this->toxml($comboheader, "xml", array("result"));
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $getResult = DB::connection('sqlsrv4')
            ->select("EXEC spxmlInsertComboLines'" .$conmboLines. "','". $userName . "'," . $userid.",".$comboHeaderID);
        return response()->json($getResult);
    }
    public function combospecialsjsonlines(Request $request){
        $comboheader = $request->get('combolinesid');
        $queryCustomers =  DB::connection('sqlsrv3')
            ->select("EXEC spGetComboLines ".$comboheader);

        return response()->json($queryCustomers);
    }
    public function groupspecials()
    {
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder')->orderBy('PastelDescription','ASC')->distinct()->get();
        $statement = "Select";
        $queryCustomers =  DB::connection('sqlsrv3')
            ->select("EXEC spGetCustomerGroups '".$statement."'");
            return view('dims/groupspecials/index')
                ->with('products',$queryProducts)
                ->with('customers',$queryCustomers);
    }
    public function viewgroupinexcel($dateFrom,$dateTo,$groupId)
    {
        return view('dims/viewgroupspecialsexcel')
            ->with('dateFrom',$dateFrom)
            ->with('dateTo',$dateTo)
            ->with('groupid',$groupId);
    }
    public function jsonViewgroupspecialExcel($dateFrom,$dateTo,$groupId)
    {
        $UserId= Auth::user()->UserID;
        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select('exec spGroupSpecialFilter ?,?,?,?',
                array($groupId,$dateFrom,$dateTo,$UserId));
        return response()->json($GetCustomerSpecail);
    }
    public function massgridspecialscustomer()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder')->orderBy('PastelDescription','ASC')->distinct()->get();
//[]
        $salesmancode =  DB::connection('sqlsrv3')
            ->select("select * from viewSalesCode");
        $dateFrom = (new \DateTime())->format('d-m-Y');
        $dateTo = (new \DateTime())->format('d-m-Y');
        $massDataInfo=  DB::connection('sqlsrv3')
            ->select("EXEC spGridMassCustomerSpecial ");
        $strSalesmanCode= Auth::user()->strSalesmanCode;

        return view('dims/mass_datagrid')
            ->with('products',$queryProducts)
            ->with('massspecialinfo',$massDataInfo)->with('datestring','No Date Chosen')
            ->with('dateFrom',$dateFrom)
            ->with('dateTo',$dateTo)
            ->with('marginG','-1')
            ->with('customers',$queryCustomers)->with('salesmancodes',$salesmancode)->with('currentRep',$strSalesmanCode);
    }
    public function getJsonCustomerGrid(Request $request)
    {
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');
        $marginless = $request->get('marginfilterless');
        $margingreater = $request->get('marginfiltergreater');
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d');
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');

      //  dd("EXEC spGridMassCustomerSpecialDateFilter '".$dateFrom."','".$dateTo."','".$marginless."','".$margingreater."'");
        $massDataInfo=  DB::connection('sqlsrv3')
            ->select("EXEC spGridMassCustomerSpecialDateFilter '".$dateFrom."','".$dateTo."','".$marginless."','".$margingreater."'");

        return response()->json($massDataInfo);
    }
    public function customerupdatepricingfromcustomerssalespage($custCode,$datefrom,$dateto,$datefrom2,$dateto2)
    {

        $massDataInfo=  DB::connection('sqlsrv3')
            ->select("EXEC spGridCustomerPricing '".$custCode."','".$datefrom."','".$dateto."','".$datefrom2."','".$dateto2."'");

        return view('dims/customergridpricing')
            ->with('dateFrom',$datefrom)->with('dateto',$dateto)
            ->with('dateFrom2',$datefrom2)->with('dateto2',$dateto2)
            ->with('custAcc',$custCode)
            ->with('customergridpricing',$massDataInfo);

    }
    public function viewcustomerpricingjson($custCode,$datefrom,$dateto,$datefrom2,$dateto2){
        return view('dims/customerpricingexcel')
            ->with('dateFrom',$datefrom)->with('dateto',$dateto)
            ->with('dateFrom2',$datefrom2)->with('dateto2',$dateto2)
            ->with('custAcc',$custCode);
    }
    public function printcustomerpricingjson($custCode,$datefrom,$dateto,$datefrom2,$dateto2)
    {
        $massDataInfo=  DB::connection('sqlsrv3')
            ->select("EXEC spGridCustomerPricing '".$custCode."','".$datefrom."','".$dateto."','".$datefrom2."','".$dateto2."'");
        return response()->json($massDataInfo);
    }
    public function updatecustomergridpricing(Request $request)
    {
        $griddetails = $request->get('griddetails');//
        $array = array();
        $i = 0;
        foreach ($griddetails as $value) {
            $massDataInfo=  DB::connection('sqlsrv3')
                ->select("EXEC spGridCustomerPricingUpdateCreated '".$value['theProductCode_']."','".$value['dateFrom']."','".$value['dateTo']."','".$value['Price_']."','".$value['listprice']."','".$value['custCode']."','".$value['cutp_']."'");
            $array[$i] = $massDataInfo[0]->returnedPrice;
            $i++;
        }
        return $array;
    }
    public function pickingLiveGrid()
    {
        $performanceTop =DB::connection('sqlsrv3')->select("SELECT * FROM viewLoadingPickingUserPerformance Order by TotalMass desc");

        return view('dims/userperformancegrid')
            ->with('performance',$performanceTop);
    }
    public function driverLiveGrid()
    {
        return view('dims/drivers_board');
    }
    public function userpickingloadingperformancereport()
    {
        return view('dims/userpickingloadingperformancereport');
    }
    public function userpickingloadingperformancereportJson($datefrom,$dateTo)
    {
        //
        $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
            ->select("EXEC spUserPerformancePickingLoading '".$datefrom."','".$dateTo."'");
        return response()->json($gridcustomerjsonspecials);

    }
    public function advancedcustomerspecials()
    {
        return view('dims/ag_mass_customer_special_grid');
    }
    public function advancedcustomerspecialsJson()
    {
        $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
            ->select("EXEC spAdvancedCustomerGridSpecials ");
        return response()->json($gridcustomerjsonspecials);
    }
    public function masscusterspecialdatefilter($dateFrom,$dateTo,$marginless,$margingreater,$repCode)
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder')->orderBy('PastelDescription','ASC')->distinct()->get();
//[]
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d');
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');
        $massDataInfo=  DB::connection('sqlsrv3')
            ->select("EXEC spGridMassCustomerSpecialDateFilter '".$dateFrom."','".$dateTo."','".$marginless."','".$margingreater."','".$repCode."'");

        $salesmancode =  DB::connection('sqlsrv3')
            ->select("select * from viewSalesCode");
        $dateToField = (new \DateTime($dateTo))->format('d-m-Y');
        $dateFromFeild = (new \DateTime($dateFrom))->format('d-m-Y');
        $strSalesmanCode= Auth::user()->strSalesmanCode;

        if(strlen(trim($strSalesmanCode) ) < 1)
        {
            $strSalesmanCode = "-99";
        }

        return view('dims/mass_datagrid')
            ->with('products',$queryProducts)->with('marginG',$margingreater)
            ->with('massspecialinfo',$massDataInfo)->with('datestring',$dateFrom." TO ".$dateTo)->with('dateFrom',$dateFromFeild)->with('dateTo',$dateToField)
            ->with('customers',$queryCustomers)->with('salesmancodes',$salesmancode)->with('currentRep',$strSalesmanCode);

    }
    public function changefiltereddatamassspecials($marginfiltergreater,$marginfilterless,$dateFromFilter,$dateToFilter,$currentRep)
    {
        $salesmancode =  DB::connection('sqlsrv3')
            ->select("select * from viewSalesCode");
        return view('dims/changefiltered_mass_specials')
            ->with('marginfiltergreater',$marginfiltergreater)
            ->with('marginfilterless',$marginfilterless)
            ->with('dateFromFilter',$dateFromFilter)
            ->with('dateToFilter',$dateToFilter)
            ->with('currentRep',$currentRep)->with('salesmancodes',$salesmancode)
            ;
    }
    public function increasePriceUsingMargin(Request $request)
    {
        //[spGridMassCustomerSpecialDateFilterMarginIncrease]
        $dateFrom =  $request->get('dateFromFilter');
        $dateTo =  $request->get('dateToFilter');
        $marginless =  $request->get('marginfilterless');
        $margingreater =  $request->get('marginfiltergreater');
        $filtermarg=  $request->get('filtermarg');
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d');
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');

        $massDataInfo=  DB::connection('sqlsrv3')
            ->statement("EXEC spGridMassCustomerSpecialDateFilterMarginIncrease '".$dateFrom."','".$dateTo."','".$marginless."','".$margingreater."',".$filtermarg);

       // return $massDataInfo;
    }
    public function masscustomerspecialupgrade(Request $request)
    {

        $griddetails = $request->get('griddetails');//hiddenChanged_
        $counter = 0;
        $UserName = Auth::user()->UserName;
        $message = array();
        $ids = -99;
        $price = -99;
        foreach ($griddetails as $value) {
            $ids = $value['hiddenChanged_'];
            $price = $value['prodPrice_'];
            if(strlen($ids ) < 1)
            {
                $ids = -99;
            }
            if(strtoupper($price)=="NAN" )
            {
                $price = 0;
            }
            $dateFrom = (new \DateTime($value['dateFrom']))->format('Y-m-d');
            $dateTo = (new \DateTime($value['dateTo']))->format('Y-m-d');
            $insertOrderDetails = DB::connection('sqlsrv3')
                ->select("EXEC spUpdateMassCustomerSpecials '" .$value['theProductCode_']. "','".$value['customerCode']."',
                ".$price.",'".$dateFrom."','".$dateTo."',".$value['margin'].",".$ids.",'".$UserName."',".$value['cost_']);


            $message[$counter] = $insertOrderDetails[0]->result;
            $counter++;
        }
        return response()->json($message);
    }


    public function andNewSpecial()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder')->orderBy('PastelDescription','ASC')->distinct()->get();

        return view('dims/add_new_customer_special')
                ->with('products',$queryProducts)
                ->with('customers',$queryCustomers);
    }
    public function customerspecialTemplate()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();

        return view('dims/exportImportSpecials')->with('customers',$queryCustomers);
    }
    public function addNewGroupSpecial()
    {
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder')->orderBy('PastelDescription','ASC')->distinct()->get();
        $statement = "Select";
        $queryCustomers =  DB::connection('sqlsrv3')
            ->select("EXEC spGetCustomerGroups '".$statement."'");
        return view('dims/addnewgroupspecial/index')
            ->with('products',$queryProducts)
            ->with('customers',$queryCustomers);

    }

    public function createCustomerSpecials(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $customerId = $request->get('customerId');
        $orderDetails = $request->get('orderDetails');
        $date = (new \DateTime($request->get('contractDateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('contractDateTo')))->format('Y-m-d');
       // $sessionUserName = Auth::user()->UserName;
        $UserID = Auth::user()->UserID;
        $UserName = Auth::user()->UserName;
        $statement = 'Insert';
        $id = DB::connection('sqlsrv3')->table('tblCustomerSpecialHeader')->insertGetId(
            ['CustomerId' => $customerId, 'DateFrom' => $date, 'DateTo' => $dateTo, 'SalesRep' => $UserName]
        );
        foreach ($orderDetails as $value) {
            $innerDateFrom = (new \DateTime($value['dateFrom']))->format('Y-m-d');
            $innerDateTo = (new \DateTime($value['dateTo']))->format('Y-m-d');
          DB::connection('sqlsrv3')
                ->statement("EXEC spCRUDCustomerSpecials ".$customerId.",'".$value['productCode']."',
                '".$innerDateFrom."','".$innerDateTo."',".$value['price'].",".$value['cost_'].",".$value['gp_'].",".$id.",".$UserID.",'".$UserName."','".$statement."'");

        }

        return response()->json($id);

    }
    public function XmlCreateCustomerSpecials(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $customerId = $request->get('customerId');
        $orderDetails = $request->get('orderDetails');
        $orderDetailsxml = $this->toxml($orderDetails, "xml", array("result"));
        $date = (new \DateTime($request->get('contractDateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('contractDateTo')))->format('Y-m-d');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;


        //dd($orderDetailsxml);
        //echo "EXEC spXMLCustomerSpecials '".$orderDetailsxml."',".$userid.",'".$userName."','".$date."','".$dateTo."',".$customerId,$contractId;
        $returnresults = DB::connection('sqlsrv3')
            ->select("EXEC spXMLCustomerSpecials '".$orderDetailsxml."',".$userid.",'".$userName."','".$date."','".$dateTo."',".$customerId);
        $outPut['result'] = $returnresults[0]->Result;
        return $outPut;

    }
    public function XmlBulkEditingCustomerSpecials(Request $request)
    {

        $orderDetails = $request->get('value');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;

        $orderDetailsxml = $this->toxml($orderDetails, "xml", array("result"));

        $returnresults = DB::connection('sqlsrv3')
            ->select("EXEC spXMLBulkEditCustomerSpecials '".$orderDetailsxml."',".$userid.",'".$userName."'");
        $outPut['result'] = 'DONE';
        return $outPut;

    }
    public function XmlBulkEditingGroupSpecials(Request $request)
    {

        $orderDetails = $request->get('value');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;

        $orderDetailsxml = $this->toxml($orderDetails, "xml", array("result"));

       //echo"EXEC spXMLBulkEditGroupSpecials '".$orderDetailsxml."',".$userid.",'".$userName."'";
        $returnresults = DB::connection('sqlsrv3')
            ->select("EXEC spXMLBulkEditGroupSpecials '".$orderDetailsxml."',".$userid.",'".$userName."'");
        $outPut['result'] = 'DONE';
        return $outPut;

    }
    public function createGroupSpecials(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $customerId = $request->get('customerId');
        $orderDetails = $request->get('orderDetails');
        $date = (new \DateTime($request->get('contractDateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('contractDateTo')))->format('Y-m-d');
       // $sessionUserName = Auth::user()->UserName;
        $UserID = Auth::user()->UserID;
        $UserName = Auth::user()->UserName;
        $statement = 'Insert';
        $id = DB::connection('sqlsrv3')->table('tblGroupSpecialsHeader')->insertGetId(
            ['GroupId' => $customerCode, 'DateFrom' => $date, 'DateTo' => $dateTo]
        );
        foreach ($orderDetails as $value) {
            $innerDateFrom = (new \DateTime($value['dateFrom']))->format('Y-m-d');
            $innerDateTo = (new \DateTime($value['dateTo']))->format('Y-m-d');
          DB::connection('sqlsrv3')
                ->statement("EXEC spCRUDGroupSpecials ".$customerCode.",'".$value['productCode']."',
                '".$innerDateFrom."','".$innerDateTo."',".$value['price'].",".$value['cost_'].",".$value['gp_'].",".$id.",".$UserID.",'".$UserName."','".$statement."'");

        }

        return response()->json($id);

    }
    public function createOverallSpecials(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $customerId = $request->get('customerId');
        $orderDetails = $request->get('orderDetails');
        $date = (new \DateTime($request->get('contractDateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('contractDateTo')))->format('Y-m-d');
       // $sessionUserName = Auth::user()->UserName;
        $UserID = Auth::user()->UserID;
        $UserName = Auth::user()->UserName;
        $statement = 'Insert';
        $id = DB::connection('sqlsrv3')->table('tblOverallSpecialsHeader')->insertGetId(
            ['DateFrom' => $date, 'DateTo' => $dateTo]
        );
        foreach ($orderDetails as $value) {
            $innerDateFrom = (new \DateTime($value['dateFrom']))->format('Y-m-d');
            $innerDateTo = (new \DateTime($value['dateTo']))->format('Y-m-d');
          DB::connection('sqlsrv3')
                ->statement("EXEC spCRUDOverallSpecials ".$customerCode.",'".$value['productCode']."','".$innerDateFrom."','".$innerDateTo."',".$value['price'].",".$value['cost_'].",".$value['gp_'].",".$id.",".$UserID.",'".$UserName."','".$statement."',". 1/*$value['specialType']*/ .",".$value['locations']);
//
        }

         return response()->json($id);

    }


    public function customerByDateOrContract(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $dateFrom = (new \DateTime($request->get('dateFrom')))->format('Y-m-d') ;
        $dateTo = (new \DateTime($request->get('dateTo')))->format('Y-m-d');
        $contractId = $request->get('contractId');
        $userID = Auth::user()->UserID;

        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select('exec spCustomerSpecialFilter ?,?,?,?',
                array($customerCode,$dateFrom,$dateTo,$userID)
            );
        return response()->json($GetCustomerSpecail);
        //spCustomerSpecialFilter
//SpecialHeaderId
    }
    public function customerspecialsbulkediting($customerCode,$dateFrom,$dateTo)
    {
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d') ;
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');
        $userID = Auth::user()->UserID;
        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select('exec spCustomerSpecialFilter ?,?,?,?',
                array($customerCode,$dateFrom,$dateTo,$userID)
            );
        return response()->json($GetCustomerSpecail);
    }
    public function groupspecialsbulkediting($customerCode,$dateFrom,$dateTo)
    {
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d') ;
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');
        $userID = Auth::user()->UserID;
        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select('exec spGroupSpecialFilter ?,?,?,?',
                array($customerCode,$dateFrom,$dateTo,$userID)
            );
        return response()->json($GetCustomerSpecail);
    }
    public function getbulkeditingLandingage($customerCode,$dateFrom,$dateTo)
    {
        return view('dims/startbukeditingcustomerspecials')
            ->with('custcode',$customerCode)
            ->with('datefrom',$dateFrom)
            ->with('dateTo',$dateTo)
            ;
    }
    public function getgroupspecialbulkeditingLandingage($groupId,$dateFrom,$dateTo)
    {
        return view('dims/bulkeditgroupspecials')
            ->with('groupId',$groupId)
            ->with('datefrom',$dateFrom)
            ->with('dateTo',$dateTo)
            ;
    }
    public function overallSpecailByDateOrContract(Request $request)
    {
        $customerCode = 99;
        $dateFrom = (new \DateTime($request->get('dateFrom')))->format('Y-m-d') ;
        $dateTo = (new \DateTime($request->get('dateTo')))->format('Y-m-d');
        $contractId = $request->get('contractId');

        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select("EXEC spOverallSpecialFilter '".$customerCode."','".$dateFrom."','".$dateTo."'");
        return response()->json($GetCustomerSpecail);
        //spCustomerSpecialFilter
//SpecialHeaderId
    }
    public function customerGroupByDateOrContract(Request $request)
    {
        $groupId = $request->get('groupId');
        $dateFrom = (new \DateTime($request->get('dateFrom')))->format('Y-m-d') ;
        $dateTo = (new \DateTime($request->get('dateTo')))->format('Y-m-d');
        $contractId = $request->get('contractId');
        $userID = Auth::user()->UserID;

        $GetCustomerSpecail = DB::connection('sqlsrv3')
        ->select('exec spGroupSpecialFilter ?,?,?,?',
        array($groupId,$dateFrom,$dateTo,$userID)
    );
        return response()->json($GetCustomerSpecail);
        //spCustomerSpecialFilter
//SpecialHeaderId
    }
    public function updatespeciialLine(Request $request)
    {
        $itemCode = $request->get('itemCode');
        $specialIdUpdate = $request->get('specialIdUpdate');
        $itemDescription = $request->get('itemDescription');

        $specialFrom = (new \DateTime($request->get('specialFrom')))->format('Y-m-d') ;
        $specialTo = (new \DateTime($request->get('specialTo')))->format('Y-m-d');
        $specialPrice = $request->get('specialPrice');
        $specialCost = $request->get('specialCost');
        $specialGp = $request->get('specialGp');
        $productId = DB::connection('sqlsrv3')->table('tblProducts')->select('ProductId')->where('PastelCode',$itemCode)->get();

        DB::connection('sqlsrv3')->table('tblCustomerSpecials')
            ->where('CustomerSpecial',$specialIdUpdate )
            ->update(['Date' => $specialFrom,'DateTo' => $specialTo,'Price' => $specialPrice,'GP'=>$specialGp,'CostPrice'=>$specialCost,
                'ProductId'=>$productId[0]->ProductId]);


        return  response()->json(1);
    }
    public function updategGroupSpecialLine(Request $request)
    {
            $itemCode = $request->get('itemCode');
            $specialIdUpdate = $request->get('specialIdUpdate');
            $itemDescription = $request->get('itemDescription');
        $specialFrom = (new \DateTime($request->get('specialFrom')))->format('Y-m-d') ;
        $specialTo = (new \DateTime($request->get('specialTo')))->format('Y-m-d');
            $specialPrice = $request->get('specialPrice');
            $specialCost = $request->get('specialCost');
            $specialGp = $request->get('specialGp');
            $productId = DB::connection('sqlsrv3')->table('tblProducts')->select('ProductId')->where('PastelCode',$itemCode)->get();


            DB::connection('sqlsrv3')->table('tblGroupSpecials')
                ->where('SpecialGroupid',$specialIdUpdate )
                ->update(['Date' => $specialFrom,'DateTo' => $specialTo,'Price' => $specialPrice,'GP'=>$specialGp,'CostPrice'=>$specialCost,
                    'ProductId'=>$productId[0]->ProductId]);

            return  response()->json(1);
    }
    public function updateOverallSpecialLine(Request $request)
    {
            $itemCode = $request->get('itemCode');
            $specialIdUpdate = $request->get('specialIdUpdate');
            $itemDescription = $request->get('itemDescription');
            $specialFrom = (new \DateTime($request->get('specialFrom')))->format('Y-m-d') ;
             $specialTo = (new \DateTime($request->get('specialTo')))->format('Y-m-d');
            $specialPrice = $request->get('specialPrice');
            $specialCost = $request->get('specialCost');
            $specialGp = $request->get('specialGp');
            $productId = DB::connection('sqlsrv3')->table('tblProducts')->select('ProductId')->where('PastelCode',$itemCode)->get();


            DB::connection('sqlsrv3')->table('tblOverallSpecials')
                ->where('Specialid',$specialIdUpdate )
                ->update(['Date' => $specialFrom,'DateTo' => $specialTo,'Price' => $specialPrice,'GP'=>$specialGp,'CostPrice'=>$specialCost,
                    'ProductId'=>$productId[0]->ProductId]);

            return  response()->json(1);
    }

    public function removeCustomerSpecial(Request $request)
    {
        $itemCode = $request->get('removeSpecial');
        DB::connection('sqlsrv3')->table('tblCustomerSpecials')
            ->where('CustomerSpecial',$itemCode)
            ->delete();
        return  response()->json($itemCode);
    }
    public function removeGroupSpecial(Request $request)
    {
        $itemCode = $request->get('removeSpecial');
        DB::connection('sqlsrv3')->table('tblGroupSpecials')
            ->where('SpecialGroupid',$itemCode)
            ->delete();
        return  response()->json($itemCode);
    }
    public function removeOverallSpecial(Request $request)
    {
        $itemCode = $request->get('removeSpecial');
        DB::connection('sqlsrv3')->table('tblOverallSpecials')
            ->where('Specialid',$itemCode)
            ->delete();
        return  response()->json($itemCode);
    }
    public function changesalesman(Request $request)
    {
        $userID = $request->get('userID');
        $OrderID = $request->get('OrderId');
        $authUserName= $request->get('authUserName');
        $authUserPassword= $request->get('authUserPassword');
        $DriverDeliveryDate= $request->get('DriverDeliveryDate');
        if (config('app.IS_API_BASED')) {
            $hasAccess = $this->apiChangesalesman([
                'userID' => $userID,
                'OrderID' => $OrderID,
                'authUserName' => $authUserName,
                'authUserPassword' => $authUserPassword,
                'DriverDeliveryDate' => $DriverDeliveryDate
            ]);
        } else {
            $userAuth = Auth::user()->UserName;
            $userAuthID = Auth::user()->UserID;
            $userGroupId = Auth::user()->GroupId;

            $v  =  new \App\Http\Controllers\SalesForm();

            $activeUser= DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('GroupId','UserID', 'UserName','Password')
                ->where('UserName',$authUserName)->where('Password',$authUserPassword)->get();
            $hasAccess = "Sorry ,you don't have access to authorize accounts";
            if (count($activeUser) > 0) {
                $things = $v->getThings($activeUser[0]->GroupId,'Change Salesman');
                if ($things != "0") {
                    $salescodes = DB::connection('sqlsrv3')->table('tblOrderSalesCodes')->select('OrderId')->where('OrderId',$OrderID)->get();
                    $DriverDeliveryDate = (new \DateTime($DriverDeliveryDate))->format('Y-m-d H:i:s') ;
                    if ( count($salescodes) > 0) {
                        DB::connection('sqlsrv3')->table('tblOrderSalesCodes')
                            ->where('OrderId',$OrderID )
                            ->update(['SalesCode' => $userID, 'OrderId' => $OrderID,'DriverDeliveryDate' => $DriverDeliveryDate]);
                    } else {
                        DB::connection('sqlsrv3')->table('tblOrderSalesCodes')->insert(
                            ['SalesCode' => $userID, 'OrderId' => $OrderID,'DriverDeliveryDate' => $DriverDeliveryDate,'OrderCancelled' => 0]);
                    }
                    DB::connection('sqlsrv3')->table('tblManagementConsol')->insert(
                        ['ConsoleTypeId' => 88, 'Importance' => 1,'LoggedBy' => $userAuth,'Message' => "Order assigned to Rep Code ".$userID." by ".$userAuth,
                            'UserId' => $userAuthID,'OrderId' => $OrderID,'DocNumber'=>$OrderID]);
                    $hasAccess = "DONE";
                }
            }
        }

        return $hasAccess;
    }
    public function changerouteonorder(Request $request)
    {
        $OrderID= $request->get('OrderId');
        $RouteID= $request->get('routeId');
        if (config('app.IS_API_BASED')) {
            $newRoute = $this->apiChangerouteonorder([
                'OrderID' => $OrderID,
                'RouteID' => $RouteID,
            ]);
        } else {
            $userAuth = Auth::user()->UserName;
            $userAuthID = Auth::user()->UserID;

            $GroupId = Auth::user()->GroupId;
            if ($RouteID == 1138){
                DB::connection('sqlsrv3')->statement("EXEC spTriggerUplift ?,?",array($OrderID,1));
            } else{
                DB::connection('sqlsrv3')->statement("EXEC spTriggerUplift ?,?",array($OrderID,0));
            }
           // $things = (new SalesForm())->getThings($GroupId,'Allow Call Logger');

            $OurderRoute = DB::connection('sqlsrv3')->table('tblOrders')->select('RouteId')->where('OrderId',$OrderID)->get();
            //dd($OurderRoute);
            $currentRoute = $this->returnRouteName($OurderRoute[0]->RouteId);
            DB::connection('sqlsrv3')->table('tblOrders')
                ->where('OrderId',$OrderID )
                ->update(['routeid' => $RouteID]);
            $OurderRoutenew = DB::connection('sqlsrv3')->table('tblOrders')->select('RouteId')->where('OrderId',$OrderID)->get();
            $newRoute = $this->returnRouteName($OurderRoutenew[0]->RouteId);

            DB::connection('sqlsrv3')->table('tblManagementConsol')->insert([
                'ConsoleTypeId' => 88,
                'Importance' => 1,
                'LoggedBy' => $userAuth,
                'Message' => "Change the Route from" . $currentRoute . " to " . $newRoute,
                'UserId' => $userAuthID,
                'OrderId' => $OrderID,
                'OrderId' => $OrderID,
                'DocNumber'=>$OrderID
            ]);
        }

        return  $newRoute;
    }
    public function returnRouteName($routeid)
    {

        //$route = DB::connection('sqlsrv3')->table('tblRoutes')->select('Route')->where('Routeid',$routeid)->get();
        $route =DB::connection('sqlsrv3')
            ->select('Select * from tblRoutes where Routeid='.$routeid);

        return $route[0]->Route;
    }
    public function customersalesperiod($datefrom,$dateto)
    {
        $itemsold = DB::connection('sqlsrv3')
            ->select("EXEC spCustomerItemsold '".$datefrom."','".$dateto."'");
        return response()->json($itemsold);
    }
    public function customersalesperiodwebpage()
    {
        return view('dims/itemsold');
    }
    public function custometPricingPage($customerid)
    {
        return view('dims/customer_pricing')->with('custid',$customerid);
    }
    public function custometPricingJson($customerid)
    {
        $pricing = DB::connection('sqlsrv3')
            ->select("EXEC spCustomerPricing ".$customerid);
        return response()->json($pricing);

    }

    public function customersalespage()
    {
        $this->authorize('isAllowCompanyPermission', ['App\Models\CompanyPermission', 'isallowcustomersalestrend']);
        return view('dims/customersalescomparison');
    }
    public function customersalesJson($datefrom1,$dateto1,$datefrom2,$dateto2)
    {
        $salestrends = DB::connection('sqlsrv3')
            ->select("EXEC spCustomerOrdersDateRange '".$datefrom1."','".$dateto1."','".$datefrom2."','".$dateto2."'");
        return response()->json($salestrends);
    }
    public function warehouseProductStockLookUp(Request $request)
    {
        $prodCode =  $request->get('prodCode');
        $warehouseid =  $request->get('warehouseid');
        $userid = Auth::user()->UserID;

        //

        $warehouseinstock = DB::connection('sqlsrv3')
            ->select("EXEC spProductWareHouseStockLookUp '".$prodCode."',".$warehouseid.",".$userid."");
        return response()->json($warehouseinstock);
    }
    public function uploader(Request $request)
    {
        $file =  $request->file('files');
     //   dd($file);
        $errors = [];
        $path = 'uploads/';
        $extensions = ['jpg', 'jpeg', 'png', 'gif','xlsx'];


        $file[0]->getClientOriginalName();

//Display File Extension
        $file[0]->getClientOriginalExtension();

//Display File Real Path
        $file[0]->getRealPath();

//Display File Size
        $file[0]->getSize();

//Display File Mime Type
        $file[0]->getMimeType();

//Move Uploaded File
        $destinationPath = base_path() . '/public/uploads';
        $file[0]->move($destinationPath,$file[0]->getClientOriginalName());


        return response()->json($destinationPath."/".$file[0]->getClientOriginalName());
     //   return response()->json($destinationPath."/".$file[0]->getClientOriginalName());

    }
    public function customerDeliveryAddress($customerCode)
    {
        //
        $returnAddresses = DB::connection('sqlsrv3')
            ->select("EXEC spCustAddress '".$customerCode."'");
        return response()->json($returnAddresses);
    }
    public function selectCustomerAddressToUpdate($addressID,$address1,$address2,$address3,$address4,$address5,$customercode)
    {
        //
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute','mnyCustomerGp','ID','Warehouse')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();

        return view('dims/customerdelivery_address_to_update')
            ->with('DeliveryAddressId',$addressID)
            ->with('DeliveryAddress1',$address1)
            ->with('DeliveryAddress2',$address2)
            ->with('DeliveryAddress3',$address3)
            ->with('DeliveryAddress4',$address4)
            ->with('customercode',$customercode)
            ->with('DeliveryAddress5',$address5)->with('customers',$queryCustomers)
            ;
    }
    public function customerAddressLandingPage()
    {
        //
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute','mnyCustomerGp','ID','Warehouse')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        return view('dims/customerdelivery_address')->with('customers',$queryCustomers);
    }
    public function getDeliveryAddressOrderPattern($CustomerCode,$DeliveryAddressIId)
    {
        $orderID = 0;
        $GetOrderPattern = DB::connection('sqlsrv3')
            ->select("Exec spReturnOrderPatternForADeliveryAddress ".$DeliveryAddressIId);
        return response()->json($GetOrderPattern);
    }
    public function startcopyingorderpatternhistorytoaccount(Request $request)
    {
        $deliveryaddressid = $request->get('deliveryaddressid');
        $newCustomecode = $request->get('newCustomerode');
        $GetOrderPattern = DB::connection('sqlsrv3')
            ->statement("Exec spCopyDeliveryAddressToTheNewAccount ".$deliveryaddressid.",'".$newCustomecode."'");
        return response()->json("done");
    }

    public function deleteaddressonthecustomerdeliveryaddresstbl(Request $request)
    {
        //deleteaddressonthecustomerdeliveryaddresstbl
        $deliveryaddressid = $request->get('deliveryaddressid');
        DB::connection('sqlsrv3')->table('tblCustomerDeliveryAddress')->where('DeliveryAddressId',$deliveryaddressid)->delete();
        return response()->json("Deleted ".$deliveryaddressid);
    }
    public function deleteselectedgroupspeciallines(Request $request)
    {
        $griddetails = $request->get('griddetails');//
        $groupid = $request->get('groupid');//
        foreach ($griddetails as $value) {
            $lineid = $value['lineid'];
            DB::connection('sqlsrv3')->table('tblGroupSpecials')->where('SpecialGroupid',$lineid)->delete();
        }
        $gridxml = $this->toxml($griddetails, "xml", array("result"));
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $getResult = DB::connection('sqlsrv4')
            ->statement("EXEC spXMLdeleteselectedGroupSpecial '" . $gridxml . "','" . $userName . "'," . $userid.",".$groupid);
        return response()->json("Grid Results ");
    }
    public function deleteselectedcustomerspeciallines(Request $request)
    {
        $griddetails = $request->get('griddetails');//
        $customerId= $request->get('customerId');//
        foreach ($griddetails as $value) {
            $lineid = $value['lineid'];
            DB::connection('sqlsrv3')->table('tblCustomerSpecials')->where('CustomerSpecial',$lineid)->delete();
        }
        $gridxml = $this->toxml($griddetails, "xml", array("result"));
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $getResult = DB::connection('sqlsrv4')
            ->statement("EXEC spXMLdeleteselectedCustomerSpecial '" . $gridxml . "','" . $userName . "'," . $userid.",".$customerId);
        return response()->json("Grid Results ");
    }

    public function getCostsPerdate()
    {
        return view('dims/costs_perdate');
    }
    public function spGetCostsPerDate($date1,$date2)
    {
        $returncosts = DB::connection('sqlsrv3')
            ->select("Exec spGetCostsPerDate '".$date1."','".$date2."'");
        return response()->json($returncosts);
    }
    public function viewdailycash()
    {
        return view('dims/dailycash');
    }
    public function getdailycash($date1,$date2)
    {
        $returncosts = DB::connection('sqlsrv3')
            ->select("Exec spGetDailyCash '".$date1."','".$date2."'");
        return response()->json($returncosts);
    }
    public function viewCreditLimit()
    {
        return view('dims/credit_limit_notes');
    }
    public function getCreditLimitJson()
    {
        $returnCustomerAndCreditLimitNotes= DB::connection('sqlsrv3')
            ->select("Exec spCustomerCreditNotes");
        return response()->json($returnCustomerAndCreditLimitNotes);

    }
    public function customernoteshistory($customerId)
    {
        $returnCustomerAndCreditLimitNotes= DB::connection('sqlsrv3')
            ->select("Exec spCRUDCustomerHistory ?,?,?,?",
            array($customerId,0,"","SELECT"));


        return view('dims/customer_creditnote_notes_list')->with('customerNotes',$returnCustomerAndCreditLimitNotes)->with('customerid',$customerId);

    }
    public function getAgeAnalysis($customerId)
    {
 //dd("Exec spLSAgedAnalysis ".$customerId);
        $returnCustomerAgeAnalysis= DB::connection('sqlsrv3')
            ->select("Exec spLSAgedAnalysis ?",
                array($customerId));
        return response()->json($returnCustomerAgeAnalysis);
    }

    public function customernoteshistoryupdate(Request $request)
    {
        $noteid = $request->get('noteid');
        $newNotes = $request->get('newNote');
        $returnCustomerAndCreditLimitNotesUpdates= DB::connection('sqlsrv3')
            ->select("Exec spCRUDCustomerHistory ?,?,?,?",
            array(0,$noteid,$newNotes,"UPDATE"));
        return response()->json($returnCustomerAndCreditLimitNotesUpdates);

    }
    public function customernoteshistorydelete(Request $request)
    {
        $noteid = $request->get('noteid');
        $newNotes = $request->get('newNote');
        $returnCustomerAndCreditLimitNotesUpdates= DB::connection('sqlsrv3')
            ->select("Exec spCRUDCustomerHistory ?,?,?,?",
            array(0,$noteid,$newNotes,"DELETE"));
        return response()->json($returnCustomerAndCreditLimitNotesUpdates);

    }
    public function customernoteshistoryinsert(Request $request)
    {
        $customerid= $request->get('customerid');
        $newNotes = $request->get('newNote');

        $returnCustomerAndCreditLimitNotesUpdates= DB::connection('sqlsrv3')
            ->select("Exec spCRUDCustomerHistory ?,?,?,?",
            array($customerid,0,$newNotes,"INSERT"));
        return response()->json($returnCustomerAndCreditLimitNotesUpdates);

    }
    public function PointGrid()
    {
        $currentDate = \Carbon\Carbon::now();
        $agoDate = $currentDate->subDays($currentDate->dayOfWeek)->subWeek();
        $agoDate = (new \DateTime($agoDate))->format('Y-m-d');
        return view ('dims/PointGrid')->with('dates',$agoDate);

    }
    public function cardsList()
    {

        return view ('dims/viewcards');
    }
    public function getPointGrid()
    {
        $getPointGrid= DB::connection('sqlsrv3')->select("select* from vwPointsForCustomers");
        return response()->json($getPointGrid);
    }
    public function getCartsGrid()
    {
        $getPointGrid= DB::connection('sqlsrv3')->select("select* from vwCardList");
        return response()->json($getPointGrid);
    }
    public function deletecard(Request $request)
    {

        $userAuth = Auth::user()->UserName;
        $userAuthID = Auth::user()->UserID;
        $userid = $request ->get('userid');
        $cardnumber = $request->get('cardnumber');
        $increasepoints = DB::connection('sqlsrv3')
            ->statement('exec spDeleteLoyaltyCard ?,?,?,?',
                array($userAuth,$userid, $userAuthID,$cardnumber)
            );
        return response()->json($increasepoints);
    }
    public function increasePoints(Request $request)
    {

        $userAuth = Auth::user()->UserName;
        $userAuthID = Auth::user()->UserID;
        $userid = $request ->get('userid');
        $pointstoincrease = $request->get('IncreasePoints');
        $increasepoints = DB::connection('sqlsrv3')
            ->statement('exec spIncreasePoints ?,?,?,?',
                array($pointstoincrease,$userid, $userAuthID,$userAuth)
            );
        return response()->json($increasepoints);
    }
    public function updatecustomerwebstoreinfo(Request $request)
    {

        $userAuth = Auth::user()->UserName;
        $userAuthID = Auth::user()->UserID;
        $userid = $request ->get('userid');
        $email = $request ->get('email');
        $cellnumber = $request ->get('cellnumber');
        $address1 = $request ->get('address1');
        $address2 = $request ->get('address2');
        $address3 = $request ->get('address3');
        $cardnumber = $request ->get('cardnumber');


        $increasepoints = DB::connection('linxbriefcase')
            ->statement('exec spUpdateCustomersBriefcaseBasicinfo ?,?,?,?,?,?,?,?,?,?',
                array($userAuth,$userAuthID, $userid,$email,$cellnumber,$address1,$address2,$address3,$cardnumber)
            );
        return response()->json($increasepoints);
    }
    public function customerPointsTrends(Request $request)
    {
        $deliveryDate = $request ->get('delvdate');
        $deliveryDate = (new \DateTime($deliveryDate))->format('Y-m-d');
        $userid = $request ->get('userid');
        $earnedPoints = DB::connection('linxbriefcase')
            ->select('exec spCustomerPointsEarnedTrend ?,?',
                array($deliveryDate,$userid)
            );
        $redeemedPoints = DB::connection('linxbriefcase')
            ->select('exec spCustomerPointsRedeemedrend ?,?',
                array($deliveryDate,$userid)
            );
        $output['earned'] = $earnedPoints;
        $output['redeemed'] = $redeemedPoints;
        return $output;
    }
    public function viewStatusReport()
    {
        $Deldate = (new \DateTime())->format('Y-m-d');
        return view('dims/consolidated_report')->with('date',$Deldate);
    }
    public function getConsolidatedStatsReport(Request $request)
    {
        $date = $request->get('date');
        $returnTimeSpent= DB::connection('sqlsrv3')
            ->select("Exec spTimeSpentLoadingTrucks ?",
                array($date));
        return response()->json($returnTimeSpent);
    }
    public function UpdateDocument()
    {

        return view ('dims/UpdateDocument');

    }
    public function UpdateDocumentupdate(Request $request)
    {
        $userAuth = Auth::user()->UserName;
        $userAuthID = Auth::user()->UserID;
        $CustomerPastelCode = $request->get('CustomerPastelCode');
        $updateErrors = DB::connection('sqlsrv3')
            ->statement('exec spUpdateDocumentDocPrintOrEmail ?,?,?',
                array($CustomerPastelCode,  $userAuthID, $userAuth));
        return response()->json($updateErrors);
    }
    public function groupSetuprestrictions()
    {
      //  return view ('dims/UpdateDocument');
    }

    public function WebstoreMessages(){
        return view('dims/deletedorders');
    }
    public function getMessageGrid(){
        $getMessageGrid= DB::connection('sqlsrv3')->select("select* from tblCurrentMessage");
        return response()->json($getMessageGrid);
    }
    public function updateMessage(Request $request){
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $MessageID= $request->get('MessageID');
        $MessageHeader= $request->get('MessageHeader');
        $Message= $request->get('Message');

        $updateMessage = DB::connection('sqlsrv3')
            ->statement('exec spUpdateMessageWebstore ?,?,?,?,?',
                array($userid, $userName, $MessageID,$MessageHeader,$Message));
        return response()->json($updateMessage);
    }
    public function viewDeletedOrders()
    {
        //return view('dims/dailycash');
        return view('dims/deletedorders');
    }
    public function deleteordersJson($date1,$date2)
    {
        $returncosts = DB::connection('sqlsrv3')
            ->select("Exec spViewDeletedOrdes '".$date1."','".$date2."'");
        return response()->json($returncosts);
    }

    public function backorders()
    {
        $this->authorize('isAllowCompanyPermission', ['App\Models\CompanyPermission', 'isallowremoteorders']);
        return view('dims/backorders');
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
