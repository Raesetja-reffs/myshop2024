<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 2018/11/21
 * Time: 15:25
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;

class WareHouseController extends Controller
{

    public function warehouseInvetoryItems()
    {

        return view('dims/warehouse');

    }
    public function onOrderAdvanced()
    {

        $onorders = DB::connection('sqlsrv3')
            ->select("EXEC spOnOrderAdvanced ");
        return response()->json($onorders);
    }
}