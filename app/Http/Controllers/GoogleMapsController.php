<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoogleMapsController extends Controller
{
    function mappage($date,$routeId,$ordertypesId)
    {
        $routes = DB::connection('googlemaps')->select("SELECT RouteId,Route From tblRoutes order by Route");
        $OrderTypes = DB::connection('googlemaps')->select("SELECT OrderTypeId,OrderType From tblOrderTypes order by OrderType");

       $coordinatesResult = DB::connection('googlemaps')->select("exec [spGetDailyStops] '$date','$routeId','$ordertypesId'");
//dd($coordinatesResult);
        return view('dims/googlemaps')
            ->with('coordinates',$coordinatesResult)
            ->with('ordertypes',$OrderTypes)
            ->with('routes',$routes);
    }
    public function getRoutTripInfoSigned(Request $request)
    {

    }
    public function getCustomerSales(Request $request)
    {
        $custCode = $request->get('customercode');
        $customersalesresults = DB::connection('googlemaps')->select("exec [spGetCustomerMapYYSales] '$custCode ' ");
        return response()->json($customersalesresults);
    }
}
