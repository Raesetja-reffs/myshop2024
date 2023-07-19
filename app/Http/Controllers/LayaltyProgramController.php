<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class LayaltyProgramController extends Controller
{

    public function MapACardToTheUsers()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )
            ->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute','mnyCustomerGp','ID','Warehouse','PriceListName')
            ->where('StatusId',1)
            ->orderBy('CustomerPastelCode','ASC')->get();
        return view('dims/cardregistration')->with('customers',$queryCustomers);
    }
    public function MapACardToTheUsersWalking()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )
            ->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute','mnyCustomerGp','ID','Warehouse','PriceListName')
            ->where('StatusId',1)
            ->orderBy('CustomerPastelCode','ASC')->get();
        return view('dims/cardregistrationwalking')->with('customers',$queryCustomers);
    }
    public function CardNumberLookUp(Request $request)
    {
        $cardNumber = $request->get('cardlookupNumber');


        $returnstatement =  DB::connection('sqlsrv3')
            ->select("EXEC spCardNumberLookUp ?",
                array($cardNumber));

       // dd("EXEC spCardNumberLookUp 718300001");
        return response()->json($returnstatement);
        //$cardNumber
    }
    public function saveinfocard(Request $request)
    {
        $customerId=$request->get('CustomerId');
        $customerCode=$request->get('inputCustAcc');
        $cardNumber=$request->get('cardlookup');
        $userid = Auth::user()->UserID;
        $returnstatement =  DB::connection('sqlsrv3')
            ->select("EXEC spInsertIntoTblCustomerLoyaltyList ?,?,?,?,?",
                array($customerId,$customerCode,$cardNumber,$userid,1));

        return response()->json($returnstatement);
    }
    public function saveinfocardWalking(Request $request)
    {
        $customerId=$request->get('CustomerId');
        $customerCode= 'CAS004';
        $cardNumber=$request->get('cardlookup');
        $idnumber =$request->get('IdNumber');
        $userid = Auth::user()->UserID;
        $returnstatement =  DB::connection('sqlsrv3')
            ->select("EXEC spInsertIntoTblCustomerLoyaltyList ?,?,?,?,?",
                array($customerId,$customerCode,$cardNumber,$userid,$idnumber));

        return response()->json($returnstatement);
    }

    public function verifyemail(Request $request)
    {
        $emailverify =$request->get('verifyemail');
        //dd($emailverify);

        $returnstatement =  DB::connection('linxbriefcase')
            ->select("EXEC spPVerifyOnlineCustomer ?",
                array($emailverify));

        return response()->json($returnstatement);
    }
    public function checkifIdexists(Request $request)
    {
        $ID =$request->get('ID');
        //dd($emailverify);

        $returnstatement =  DB::connection('linxbriefcase')
            ->select("EXEC spPVerifyOnlineCustomerID ?",
                array($ID));

        return response()->json($returnstatement);
    }
}
