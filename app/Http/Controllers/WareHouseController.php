<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 2018/11/21
 * Time: 15:25
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Traits\WareHouseControllerTrait;

class WareHouseController extends Controller
{
    use WareHouseControllerTrait;

    public function warehouseInvetoryItems()
    {

        return view('dims/warehouse');

    }
    public function onOrderAdvanced()
    {
        if (config('app.IS_API_BASED')) {
            $onorders = $this->apiOnOrderAdvanced();
        } else {
            $onorders = DB::connection('sqlsrv3')->select("EXEC spOnOrderAdvanced ");
        }

        return response()->json($onorders);
    }
}
