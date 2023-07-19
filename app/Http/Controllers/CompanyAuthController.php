<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyAuthController extends Controller
{
    //
    public function viewBlockedAccount()
    {
        return view('dims/ordersblocked');
    }
    public function getBlockedAccountToAuth()
    {
        $returnwaitingAuth = DB::connection('sqlsrv3')
            ->select("SELECT * from viewOrdersWaitingAuthorisation");
        return response()->json($returnwaitingAuth);
    }
    public function getSpecificOrdersBlocked($customerId)
    {
        $returnwaitingAuth = DB::connection('sqlsrv3')
            ->select("Exec spGetSpecificOrdersToAuth $customerId");
        return view('dims/specificcustomerordersblocked')->with('customerorders',$returnwaitingAuth);
    }
    public function getSpecificBlockedOrdersJson($orderId)
    {
        $returnwaitingAuth = DB::connection('sqlsrv3')
            ->select("Exec spGetSpecificOrdersToAuth $orderId");
        return response()->json($returnwaitingAuth);
    }
    public function getoutstandingorderstoauthjson($orderId)
    {
        $returnwaitingAuth = DB::connection('sqlsrv3')
            ->select("Exec spOrderIdLines $orderId");
        return response()->json($returnwaitingAuth);
    }
    public function runAuth(Request $request)
    {
        //$returnwaitingAuth = DB::connection('sqlsrv3')
           // ->select("Exec spOrderIdLines $orderId");
        //return response()->json($returnwaitingAuth);
    }



}
