<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PickingManagementCotroller extends Controller
{
    //
    public function gridPickingSlipCollectios()
    {
        $returnGridForCollectinPickingSlips = DB::connection('sqlsrv3')->select("select * from viewCollectSalePickingOrders");
        return view('dims/gridcollectpickingslips')
            ->with('pickingslips',$returnGridForCollectinPickingSlips);
    }
    public function updateiscollected(Request $request)
    {
        $OrderId = $request->get('orderId');
        foreach ($OrderId as $value) {
            $insertOrderDetails = DB::connection('sqlsrv3')
                ->statement("EXEC spCollectThePickingSlips " . $value['orderId'] );
        }
    }
    public function reprintPickingSlip(Request $request)
    {
        $OrderId = $request->get('reprintorderId');
         DB::connection('sqlsrv3')
            ->statement("EXEC spReprintPickingSlip " . $OrderId.",0" );
    }
}
