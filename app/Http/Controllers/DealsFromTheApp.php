<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealsFromTheApp extends Controller
{
    //
    public function getDealsNotYetApproved()
    {
        $deals = DB::connection('deals')->table('vwDeals')
            ->select('strProductCode','CustomerCode','UserName','fltNewPrice','ID','dteDealStarts','dteDealEnds','blnApproved','dteTimeCreated')
            ->where('blnApproved',0)->get();
        return view('dims/deals')->with('deals',$deals);

    }
    public function approveADeal($token)
    {

        $deals = DB::connection('deals')->table('vwDeals')
            ->select('strProductCode','CustomerCode','UserName','fltNewPrice','ID','dteDealStarts','dteDealEnds','blnApproved','dteTimeCreated')
            ->where('ID',$token)->get();
        foreach(  $deals as $value )
        {
            DB::connection('sqlsrv3')
                ->statement("EXEC spMakeDeals '".$value->CustomerCode."','".$value->strProductCode."','".$value->dteDealStarts."','".$value->dteDealEnds."','".$value->UserName."','".$value->fltNewPrice."'");
            DB::connection('deals')->table('tblDeals')
                ->where('ID',$token )
                ->update(['blnApproved' => 1]);
        }

        return back();
    }
    public function rejectADeal($token)
    {
        DB::connection('deals')->table('tblDeals')
            ->where('ID',$token )
            ->update(['blnApproved' => 2]);
        return back();
    }
    public function approvedDeals()
    {
        $deals = DB::connection('deals')->table('vwDeals')
            ->select('strProductCode','CustomerCode','UserName','fltNewPrice','ID','dteDealStarts','dteDealEnds','blnApproved','dteTimeCreated')
            ->where('blnApproved',1)->orderBy('dteTimeCreated', 'desc')->take(150)->get();
        return response()->json($deals);
    }
    public function rejectedDeals()
    {
        $deals = DB::connection('deals')->table('vwDeals')
            ->select('strProductCode','CustomerCode','UserName','fltNewPrice','ID','dteDealStarts','dteDealEnds','blnApproved','dteTimeCreated')
            ->where('blnApproved',2)->orderBy('dteTimeCreated', 'desc')->take(150)->get();
        return response()->json($deals);
    }
}
