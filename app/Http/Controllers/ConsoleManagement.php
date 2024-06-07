<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AuthenticateUsersAndCentralUser;
use App\Traits\ConsoleManagementTrait;

class ConsoleManagement extends Controller
{
    use ConsoleManagementTrait;

    public function __construct()
    {
        $this->middleware(AuthenticateUsersAndCentralUser::class);
    }
    /**
     * @param $ConsoleTypeId
     * @param $Importance
     * @param $LoggedBy
     * @param $Message
     * @param int $Reviewed
     * @param int $OrderId
     * @param int $productid
     * @param int $CustomerId
     * @param $UserId
     * @param float $OldQty
     * @param float $NewQty
     * @param $OldPrice
     * @param $NewPrice
     * @param $ReviewedUserId
     * @param $ReferenceNo
     * @param $DocType
     * @param $DocNumber
     * @param $machine
     * @param $ReturnId
     * @return \Illuminate\Http\JsonResponse
     */

    public function logMessage($ConsoleTypeId,$Importance,$LoggedBy,$Message,$Reviewed,$OrderId,
                               $productid,$CustomerId,$UserId,$OldQty,$NewQty,$OldPrice,$NewPrice,$ReviewedUserId,
                               $ReferenceNo,$DocType,$DocNumber,$machine,$ReturnId)
    {

        $machine = gethostname();
        $LoggedBy = Auth::user()->UserName;
        $returnPastInvoices = DB::connection('sqlsrv3')->statement("EXEC spConsoleManagement
         ".$ConsoleTypeId.",".$Importance.",'".$LoggedBy."','".$Message."',".$Reviewed.",".$productid.",'"
            .$CustomerId."',".$UserId.",".$OldQty.",".$NewQty.",".$OldPrice.",".$NewPrice.",".$ReviewedUserId.",'"
            .$ReferenceNo."',".$DocType.",".$DocNumber.",'".$machine."',".$OrderId.",".$ReturnId);
        return response()->json($returnPastInvoices);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logMessageAjax(Request $request)
    {
        $ConsoleTypeId = $request->get('ConsoleTypeId');
        $Importance = $request->get('Importance');
        $Message= $request->get('Message');
        $Reviewed= $request->get('Reviewed');
        $OrderId= $request->get('OrderId');
        $productid= $request->get('productid');
        $CustomerId= $request->get('CustomerId');
        $OldQty= $request->get('OldQty');
        $NewQty= $request->get('NewQty');
        $OldPrice= $request->get('OldPrice');
        $NewPrice= $request->get('NewPrice');
        $ReviewedUserId = 0;
        $ReferenceNo = $request->get('ReferenceNo');
        $DocType = $request->get('DocType');
        $DocNumber = $request->get('DocNumber');
        $machine = $request->get('machine');
        $ReturnId = $request->get('ReturnId');
        if (config('app.IS_API_BASED')) {
            $returnManagemntC = $this->apiLogMessageAjax();
        } else {
            $UserId= Auth::user()->UserID;
            $LoggedBy = Auth::user()->UserName;
            $returnManagemntC = DB::connection('sqlsrv3')
                ->statement('exec spConsoleManagement ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                    array($ConsoleTypeId,$Importance,$LoggedBy,$Message,$Reviewed,$productid,$CustomerId,$UserId,$OldQty,$NewQty,$OldPrice,
                        $NewPrice,$ReviewedUserId,$ReferenceNo,$DocType,$DocNumber,$machine,$OrderId,$ReturnId)
                );
        }

        return response()->json($returnManagemntC);
    }
    public function logMessageAuth(Request $request)
    {
        $ConsoleTypeId = $request->get('ConsoleTypeId');
        $Importance = $request->get('Importance');
        $Message= $request->get('Message');
        $Reviewed= $request->get('Reviewed');
        $OrderId= $request->get('OrderId');
        $productCode= $request->get('productid');
        $CustomerId= $request->get('CustomerId');
        $UserId= Auth::user()->UserID;
        $userName= $request->get('userName');
        $OldQty= $request->get('OldQty');
        $NewQty= $request->get('NewQty');
        $OldPrice= $request->get('OldPrice');
        $NewPrice= $request->get('NewPrice');
        $ReviewedUserId = 0;
        $ReferenceNo = $request->get('ReferenceNo');
        $DocType = $request->get('DocType');
        $DocNumber = $request->get('DocNumber');
        $machine = $request->get('machine');
        $ReturnId = $request->get('ReturnId');
        $LoggedBy =  Auth::user()->UserName;
        $productId = DB::connection('sqlsrv3')->table('tblProducts')->select('ProductId')->where('PastelCode',$productCode)->get();

        $returnManagemntC = DB::connection('sqlsrv3')
        ->statement('exec spConsoleManagement ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
        array($ConsoleTypeId,$Importance,$LoggedBy,$Message,$Reviewed,$productId[0]->ProductId,$CustomerId,$UserId,$OldQty,$NewQty,$OldPrice,
            $NewPrice,$ReviewedUserId,$ReferenceNo,$DocType,$DocNumber,$machine,$OrderId,$ReturnId)
        );

        return response()->json($returnManagemntC);
    }
    public function logMessageAuthMargin(Request $request)
    {
        $ConsoleTypeId = $request->get('ConsoleTypeId');
        $Importance = $request->get('Importance');
        $Message= $request->get('Message');
        $Reviewed= $request->get('Reviewed');
        $OrderId= $request->get('OrderId');
        $productCode= $request->get('productid');
        $CustomerId= $request->get('CustomerId');
        $UserId= Auth::user()->UserID;
        $userName= $request->get('userName');
        $OldQty= $request->get('OldQty');
        $NewQty= $request->get('NewQty');
        $OldPrice= $request->get('OldPrice');
        $NewPrice= $request->get('NewPrice');
        $ReviewedUserId = 0;
        $ReferenceNo = $request->get('ReferenceNo');
        $DocType = $request->get('DocType');
        $DocNumber = $request->get('DocNumber');
        $machine = $request->get('machine');
        $ReturnId = $request->get('ReturnId');
        $LoggedBy =  Auth::user()->UserName;
        $productId = DB::connection('sqlsrv3')->table('tblProducts')->select('ProductId')->where('PastelCode',$productCode)->get();
dd("hererererere");
        $returnManagemntC = DB::connection('sqlsrv3')->table('tblManagementConsol')->insert(
            ['ConsoleTypeId' => 1010, 'Importance' => 1,
                'LoggedBy' => $LoggedBy,'Message'=>$Message,'Reviewed'=>0,'productid'=>0,
                'CustomerId' => 0,'OrderId'=>$OrderId,'DocNumber'=>$OrderId
            ]);
        DB::connection('sqlsrv3')->table('tblOrders')
            ->where('OrderId',$OrderId )
            ->update(['Authorised' => 1]);
        return response()->json($returnManagemntC);
    }
    public function deleteallLinesOnOrder(Request $request)
    {
        $orderId = $request->get('orderId');
        $delivdate =  (new \DateTime($request->get('delivdate')))->format('Y-m-d');
        $customerCode = $request->get('customerCode');
        if (config('app.IS_API_BASED')) {
            $deleteallLines = $this->apiDeleteallLinesOnOrder([
                'OrderId' => $orderId,
                'ConsoleDate' => $delivdate,
                'CustomerCode' => $customerCode,
            ]);
        } else {
            $LoggedBy = Auth::user()->UserName;
            $userId = Auth::user()->UserID;
            $deleteallLines = DB::connection('sqlsrv3')
                ->select("EXEC spDeleteAllLinesOnOrder ".$orderId.",'".$LoggedBy."',".$userId.",'".$customerCode."','".$delivdate."'");
        }

        return response()->json($deleteallLines);
    }
    public function managementcosoleresult($consoletype,$OrderId,$InvoiceNo,$ProductCode)
    {
       //echo "EXEC spCons ".$OrderId.",'".$InvoiceNo."','".$ProductCode."',".$consoletype ;
        $getConsoleData= DB::connection('sqlsrv3')
            ->select("EXEC spCons ".$OrderId.",'".$InvoiceNo."','".$ProductCode."',".$consoletype);
        return response()->json($getConsoleData);
    }
}
