<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class DimsExportController extends Controller
{
    //
    public function getExportForm()
    {
        $unEx = DB::connection('sqlsrv3')
            ->table('viewUnExportedInvoices')
            ->select('CustomerPastelCode', 'StoreName','Route','OrderType','OrderDate','DeliveryDate','OrderId','InvoiceNo','UserName')
            ->orderBy('DeliveryDate', 'asc')->get();
        $orderType = $unxportedOrders = DB::connection('sqlsrv3')->table('tblOrderTypes')
            ->select('OrderTypeId','OrderType')->orderBy('OrderTypeId', 'asc')->get();
        $route = $unxportedOrders = DB::connection('sqlsrv3')->table('tblRoutes')
            ->select('Routeid','Route')->orderBy('Route', 'asc')->get();
        $exportUser = $unxportedOrders = DB::connection('sqlsrv3')->table('tblUsers')
            ->select('Num','UserName')->where('Invoices',1)->orderBy('UserName', 'asc')->get();
        $viewStockReport = $unxportedOrders = DB::connection('sqlsrv3')->table('viewStockReport')
            ->select('PastelCode','PastelDescription','sumQty','QtyInStock')->orderBy('PastelDescription', 'asc')->get();
        return view('dims/export')
            ->with('orderTypes',$orderType)
            ->with('route',$route)
            ->with('unexp',$unEx)
            ->with('stockReport',$viewStockReport)
            ->with('exportUser',$exportUser);
    }
    public function insertIntoExportTable(Request $request)
    {
        $deliveryDate = $request->get('deliveryDate');
        $orderType = $request->get('orderType');
        $route = $request->get('route');
        $exportTo = $request->get('exportTo');
        //table here
    }
}
