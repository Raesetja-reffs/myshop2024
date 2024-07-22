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
        // Retrieve values from environment variables
        // we can handle this here if it is multi-company
        $this->companyLat = $this->getCompanyThings('CompanyLatitude', '-29.776056128512103', 'String')[0]->thing;
        $this->companyLng = $this->getCompanyThings('CompanyLongitude', '30.85026669894635', 'String')[0]->thing;
        $this->companyName = $this->getCompanyThings('CompanyName', 'Linx Systems', 'String')[0]->thing;
        $this->companyAbv = $this->getCompanyThings('CompanyAbv', 'LX', 'String')[0]->thing;
        $this->hasRO = $this->getCompanyThings('bitHasRouteOptimization', 0, 'Bool')[0]->thing;
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

        // Initialize a counter
        $counter = 1;

        if (empty($data)) {
            // $data is empty, handle the case where no lines are returned
            return ['issues' => [['message' => 'No data to optimize for that route and order type.']]];
        } else {
            // Iterate through the $data array and build the "visits" array with numeric keys
            foreach ($data as $store) {
                $visits[$counter] = [
                    "location" => [
                        "name" => $store->StoreName,
                        "lat" => floatval($store->fltLatitude),
                        "lng" => floatval($store->fltLongitude),
                        "OrderId" => $store->OrderId
                    ],
                ];
                // Increment the counter
                $counter++;
            }
        
            // Create the fleet array
            $fleet = [
                "truck" => [
                    "start_location" => [
                        "id" => "start",
                        "name" => $this->companyName,
                        "lat" => floatval($this->companyLat),
                        "lng" => floatval($this->companyLng),
                    ],
                    "end_location" => [
                        "id" => "start",
                        "name" => $this->companyName,
                        "lat" => floatval($this->companyLat),
                        "lng" => floatval($this->companyLng),
                    ],
                ],
            ];
        
            // Combine the visits and fleet arrays into the final array
            $routesArray = [
                "visits" => $visits,
                "fleet" => $fleet,
            ];

            // dd($routesArray);
        
            // Convert the array to JSON
            $routes = json_encode($routesArray);

            $ConsoleTypeId = 66;
            $LoggedBy = Auth::user()->UserName;
            $Qty = count($data);
            $Message = "Routific Request Made For ($Qty) Stops, Logged by $LoggedBy";
            $Reviewed = 0;
            $UserId = Auth::user()->UserID;

            $xmlData = $this->xmlConvert($data);
            
            // DB::connection('sqlsrv3')->statement("EXEC spLogRouteOptimizationUsage $ConsoleTypeId, '$LoggedBy', $Qty, '$Message', $Reviewed, $UserId, '$xmlData'");

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

            $visits['start'] = [
                "location" => [
                    "name" => $this->companyName,
                    "lat" => floatval($this->companyLat),
                    "lng" => floatval($this->companyLng),
                ],
            ];

            // dd($visits);

            // Create a new response array in the desired format
            $newResponse = [
                "results" => [
                    [
                        "waypoints" => [],
                    ]
                ]
            ];

            // Populate the "waypoints" array in the new format with lat and lng values from $routesArray
            foreach ($response->solution->truck as $index => $waypoint) {
                $locationId = $waypoint->location_id;
                $lat = $visits[$locationId]["location"]["lat"];
                $lng = $visits[$locationId]["location"]["lng"];

                if (isset($visits[$locationId]["location"]["OrderId"])) {
                    $OrderId = $visits[$locationId]["location"]["OrderId"];
                } else {
                    $OrderId = "STARTLOCATION";
                }

                $newResponse["results"][0]["waypoints"][] = [
                    "id" => $waypoint->location_name,
                    "lat" => $lat,
                    "lng" => $lng,
                    "OrderId" => $OrderId,
                    "sequence" => $index,
                    "estimatedArrival" => null,
                    "estimatedDeparture" => null,
                    "fulfilledConstraints" => []
                ];
            }

            return $newResponse;
        }
    }

    // public function optimizeDriversRouteRoutific(Request $request){
    //     $data = json_decode($request->get('route'));

    //     $optimizedRoute = $this->optimizeRoutesRoutific($data);

    //     return $optimizedRoute;
    // }

    public function optimizeStops(Request $request){
        $data = json_decode($request->get('routes'));
        
        // dd($data);

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

    function xmlConvert($array) {
        $xml = new \SimpleXMLElement('<data/>');
        
        foreach ($array as $productData) {
            $line = $xml->addChild('line');
            foreach ($productData as $key => $value) {
                $line->addChild($key, $value);
            }
        }

        $xml = $xml->asXML();
        $xml = str_replace("<?xml version=\"1.0\"?>\n", '', $xml);
    
        return $xml;
    }
}