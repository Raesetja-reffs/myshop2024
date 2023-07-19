<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineOrdersReconController extends Controller
{

    public function viewRefunds()
    {
        return view('dims/onlineordersrecon');
    }
    public function returnRefunds()
    {
        $viewCustomerToRefund = DB::connection('linxbriefcase')
            ->select("Select * from viewCustomerToRefund where DimsOrderID is not null");


        //dd($viewCustomerToRefund);

        $priceInfo = array();
        $main =array();
        //viewPublicOnline
        /*
         *     +"vals": "503.000000"
    +"ID": "1584802007jYCC156P0I"
    +"DimsOrderID": "562761"
    +"intpoints": "0"
    +"UserName": "paul@lsystems.co.za"
         */
        foreach ($viewCustomerToRefund as $value)
        {
            $viewPublicOnline = DB::connection('sqlsrv3')
                ->select("Select * from viewPublicOnline where strField11 = ".$value->DimsOrderID);

            foreach ($viewPublicOnline as $val2)
            {
                $priceInfo['rVal'] = $value->vals;
                $priceInfo['intpoints'] = $value->intpoints;
                $priceInfo['Email'] = $value->UserName;
                $priceInfo['DimsOrderID'] = $value->DimsOrderID;
                $priceInfo['Reference'] = $value->ID;
                $priceInfo['palladiumTotal'] = $val2->decTotal;
                $priceInfo['Inv'] = $val2->strInvDocID;
                $priceInfo['strShipTo'] = $val2->strShipTo;
                $priceInfo['dteJournalDate'] = $val2->dteJournalDate;
                $priceInfo['diff'] = round($val2->decTotal - $value->vals,2); //minus means refund
            }
            $main[] =$priceInfo;
        }
       // dd($main);
        return response()->json($main);
    }
}
