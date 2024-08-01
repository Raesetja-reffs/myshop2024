<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\RouteOptimizationTrait;


class RouteOptimizationController extends Controller
{
    use RouteOptimizationTrait;

    public $companyLat;
    public $companyLng;
    public $companyName;
    public $companyAbv;
    public $hasRO;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            // Retrieve values from environment variables
            // we can handle this here if it is multi-company
            $this->companyLat = $this->getCompanyThings('CompanyLatitude', '-29.776056128512103', 'String')[0]->thing;
            $this->companyLng = $this->getCompanyThings('CompanyLongitude', '30.85026669894635', 'String')[0]->thing;
            $this->companyName = $this->getCompanyThings('CompanyName', 'Linx Systems', 'String')[0]->thing;
            $this->companyAbv = $this->getCompanyThings('CompanyAbv', 'LX', 'String')[0]->thing;
            $this->hasRO = $this->getCompanyThings('bitHasRouteOptimization', 0, 'Bool')[0]->thing;

            return $next($request);
        });
    }

    public function routeOptimization(){
        // dd($this->hasRO);
        if ($this->hasRO == 0) {
            // return response('Please contact Linx Systems to activate Route Optimization', 403);
            abort(403, 'Please contact Linx Systems to have Route Optimization activated.');
        }else{
            if (config('app.IS_API_BASED')) {
                $routes = $this->apiGetRoutes();
                $types = $this->apiGetOrderTypes();
            } else {
                $routes = DB::connection('sqlsrv3')->select("EXEC sp_API_GetRoutes 0");
                $types = DB::connection('sqlsrv3')->select("EXEC sp_API_GetOrderTypes 0");
            }

            return view('dims.routeOptimization.index')
                ->with('routes', $routes)
                ->with('types', $types)
                ->with('companyLat', $this->companyLat)
                ->with('companyLng',  $this->companyLng)
                ->with('companyName', $this->companyName)
                ->with('companyAbv', $this->companyAbv);
        }
    }

    public function driversMap(){
        if (config('app.IS_API_BASED')) {
            $routes = $this->apiGetRoutes();
            $types = $this->apiGetOrderTypes();
        } else {
            $routes = DB::connection('sqlsrv3')->select("EXEC sp_API_GetRoutes 0");
            $types = DB::connection('sqlsrv3')->select("EXEC sp_API_GetOrderTypes 0");
        }

        return view('dims.routeOptimization.driversMap')
            ->with('routes',$routes)
            ->with('types',$types)
            ->with('companyLat', $this->companyLat)
            ->with('companyLng',  $this->companyLng)
            ->with('companyName', $this->companyName)
            ->with('companyAbv', $this->companyAbv);
    }

    public function getLiveDriversAppInfo(Request $request){
        $deldate= $request->get('deldate');
        $routename= $request->get('route');
        $ordertype= $request->get('ordertype');
        
        if (config('app.IS_API_BASED')) {
            $result = $this->apiGetLiveDriversAppInfo([
                'deldate' => $deldate,
                'routename' => $routename,
                'ordertype' => $ordertype,
            ]);
        } else {
            $result =  DB::connection('sqlsrv3')->select("EXEC sp_API_R_LiveDriversAppInfo '".$deldate."','".$routename."','".$ordertype."'");
        }

        return response()->json($result);
    }

    public function getRoutesToOptimize(Request $request){
        $deliveryDate = $request->get("deliveryDate");
        $routeId = $request->get("routeId");
        $typeId = $request->get("typeId");

        if (config('app.IS_API_BASED')) {
            $data = $this->apiGetRoutesToOptimize([
                'deliveryDate' => $deliveryDate,
                'routeId' => $routeId,
                'typeId' => $typeId
            ]);
        } else {
            $userId = Auth::user()->UserID;
            $data = DB::connection('sqlsrv3')->select("exec sp_API_R_GetRoutesToOptimize '$deliveryDate', '$routeId', '$typeId', $userId");
        }

        return response()->json($data);
    }

    public function optimizeRoutesRoutific($data){
        $visits = [];
        $originalData = $data;

        if (empty($data)) {
            return ['issues' => [['message' => 'No data to optimize for that route and order type.']]];
        }

        $first = array_shift($data);
        $last = array_pop($data);

        foreach ($data as $store) {
            $visits[$store->OrderId] = [
                "location" => [
                    "name" => $store->StoreName,
                    "lat" => floatval($store->fltLatitude),
                    "lng" => floatval($store->fltLongitude),
                    "OrderId" => $store->OrderId
                ],
            ];
        }

        $fleet = [
            "truck" => [
                "start_location" => [
                    "id" => $first->OrderId,
                    "name" => $first->StoreName,
                    "lat" => floatval($first->fltLatitude),
                    "lng" => floatval($first->fltLongitude),
                ],
                "end_location" => [
                    "id" => $last->OrderId,
                    "name" => $last->StoreName,
                    "lat" => floatval($last->fltLatitude),
                    "lng" => floatval($last->fltLongitude),
                ],
            ],
        ];

        $routesArray = [
            "visits" => $visits,
            "fleet" => $fleet,
        ];

        $routes = json_encode($routesArray);

        $ConsoleTypeId = 66;
        $Qty = count($data);

        $xmlData = $this->xmlConvert($data);

        if (config('app.IS_API_BASED')) {
            $this->apiLogRouteOptimizationUsage([
                'ConsoleTypeId' => $ConsoleTypeId,
                'Qty' => $Qty,
                'xmlData' => $xmlData,
            ]);
        } else {
            $UserId = Auth::user()->UserID;
            $LoggedBy = Auth::user()->UserName;

            // DB::connection('sqlsrv3')->statement("EXEC sp_API_C_RouteOptimizationUsage $ConsoleTypeId, '$LoggedBy', $Qty, $UserId, '$xmlData'");
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.routific.com/v1/vrp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $routes,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.env('ROUTIFIC_API')
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if($response) {
            $response = json_decode($response);
        }

        $originalDataMap = [];
        foreach ($originalData as $data) {
            $originalDataMap[$data->OrderId] = $data;
        }

        $newResponse = (object)[
            'unserved' => array_map(function($message, $id) use ($originalDataMap) {
                $origData = $originalDataMap[$id] ?? null;
                return (object)[
                    'OrderId' => $id,
                    'StoreName' => $origData->StoreName ?? null,
                    'fltLatitude' => $origData->fltLatitude ?? null,
                    'fltLongitude' => $origData->fltLongitude ?? null,
                    'reason' => $message
                ];
            }, (array)$response->unserved, array_keys((array)$response->unserved)),
            'solution' => array_map(function($loc) use ($originalDataMap) {
                $origData = $originalDataMap[$loc->location_id] ?? null;
                return (object)[
                    'StoreName' => $loc->location_name,
                    'fltLatitude' => $origData->fltLatitude ?? null,
                    'fltLongitude' => $origData->fltLongitude ?? null,
                    'OrderId' => $loc->location_id
                ];
            }, $response->solution->truck)
        ];

        return $newResponse;
    }

    public function optimizeStops(Request $request){
        $data = $request->get('routes');
        $data = json_decode(json_encode($data));

        $optimizedRoute = $this->optimizeRoutesRoutific($data);
    
        return $optimizedRoute;
    }

    public function updateCustomerGeoCoordinates(Request $request){
        $OrderId = $request->get('OrderId');
        $lat = $request->get('lat');
        $lng = $request->get('lng');

        if (config('app.IS_API_BASED')) {
            $result = $this->apiUpdateCustomerGeoCoordinates([
                "OrderId" => $OrderId,
                "lat" => $lat,
                "lng" => $lng
            ]);
        } else {
            $userId = Auth::user()->UserID;
            $UserName = Auth::user()->UserName;

            $result = DB::connection('sqlsrv3')->statement("EXEC sp_API_U_UpdateCustomerGeoCoordinates $OrderId, $lat, $lng, $userId, '$UserName'");
        }



        return response()->json($result);
    }

    public function getCompanyThings($string, $default, $type){
        if (config('app.IS_API_BASED')) {
            $result = $this->apiGetCompanyThings([
                'string' => $string,
                'default' => $default,
                'type' => $type
            ]);
        } else {
            $result = DB::connection('sqlsrv3')->select("exec sp_API_R_GetCompanyThings '$string', '$default', '$type'");
        }

        return $result;
    }

    function xmlConvert($array){
        $xml = new \SimpleXMLElement('<data/>');
    
        foreach ($array as $productData) {
            $line = $xml->addChild('line');
            foreach ($productData as $key => $value) {
                // Escape special characters
                $escapedValue = htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
                $line->addChild($key, $escapedValue);
            }
        }
    
        $xml = $xml->asXML();
        $xml = str_replace("<?xml version=\"1.0\"?>\n", '', $xml);
    
        return $xml;
    }
}
