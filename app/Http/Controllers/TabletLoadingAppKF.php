<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 03/08/2017
 * Time: 01:56 PM
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class TabletLoadingAppKF extends controller
{

    public function getRouteData(Request $request)
    {
        $routeId = $request->get('routeId');
        $deliveryDate = $request->get('deliveryDate');
        $OrderType = $request->get('OrderType');

        $getInvoicesOnRoute = DB::connection('sqlsrv3')
            ->select("EXEC getRouteOrderTypeDeliveryDateOrders '" . $deliveryDate . "'," . $OrderType . "," . $routeId . ",0,'OrderHeader'");
        return response()->json($getInvoicesOnRoute);
    }

    public function orderDetailsWithDeliveryAddress(Request $request)
    {
        $OrderId = $request->get('orderId');
        $getInvoicesOnRouteOrderDetailsDeliveryAddress = DB::connection('sqlsrv3')
            ->select("EXEC getRouteOrderTypeDeliveryDateOrders '1901-01-01',9999999,9999999," . $OrderId . ",'OrderDeliveryAddress'");

        return response()->json($getInvoicesOnRouteOrderDetailsDeliveryAddress);
    }

    public function orderDetailsWithDeliveryAddressOnOrder(Request $request)
    {
        $OrderId = $request->get('orderId');
        $getInvoicesOnRouteOrderDetailsOnOrder = DB::connection('sqlsrv3')
            ->select("EXEC getRouteOrderTypeDeliveryDateOrders '1901-01-01',9999999,9999999," . $OrderId . ",'OrderDetails'");
        return response()->json($getInvoicesOnRouteOrderDetailsOnOrder);
    }

    public function sequencingTheStops(Request $request)
    {
        $array = array();
        $ordersToStop = $request->get('ordersToStop');

        /*$delivDate =(new \DateTime($request->get('delivDate')))->format('Y-m-d H:m:s');
        $createdDate = (new \DateTime($request->get('createdDate')))->format('Y-m-d H:m:s');
        $truckId = $request->get('truckId');
        $assistant = $request->get('assistant');
        $driverId = $request->get('driverId');
        $route = $request->get('route');*/

        $i = 0;
        /*   $insertIntoTruckControlSheet = DB::connection('sqlsrv3')
               ->select("EXEC spInsertIntoTruckControlSheet " . $truckId . "," . $assistant.",".$driverId.",".$route.",'".$createdDate."','".$delivDate."'");
   */

        foreach ($ordersToStop as $value) {
            if(strlen( $value['orderId']) > 1){
                $sequence = DB::connection('sqlsrv3')
                    ->select("EXEC spUpdateOrderDeliverySequence " . $value['orderId'] . "," . $value['index']);
                $array[$i] = $sequence;
                // echo "EXEC spUpdateOrderDeliverySequence " . $value['orderId'] . "," . $value['index'];
            }
            $i++;

        }
        $outPut['count'] = count($array);

        return $outPut;
    }
    public function stopsUnmapped(Request $request)
    {
        $ordersToStop = $request->get('ordersToStop');
        $updateSort= $request->get('updateSort');
        $truckControlKeeper= $request->get('truckControlKeeper');
        $i = 0;
        $j = 0;
        $index = "NULL";
        $array2 = array();
        $array = array();

        if (!empty($ordersToStop)) {
            foreach ($ordersToStop as $value) {
                $sequence = DB::connection('sqlsrv3')
                    ->select("EXEC spUpdateOrderDeliverySequence " . $value['orderId'] . "," . $index . "," . $index);
                $array[$i] = $sequence;
                $i++;
            }
        }

        if (!empty($updateSort)) {

            foreach ($updateSort as $value) {
                if(strlen( $value['orderId']) > 1){
                    $sequence2 = DB::connection('sqlsrv3')
                        ->select("EXEC spUpdateOrderDeliverySequence " . $value['orderId'] . "," . $value['index'] . "," . $truckControlKeeper);
                    $array2[$j] = $sequence2;
                }

                $j++;
            }
        }
        $outPut['updateSort'] = count($array2) ;
        $outPut['unsequenced'] = count($array) ;
        $outPut['truckId'] =$truckControlKeeper ;
        return $outPut;
    }

    public function getRouteDataMultiSelected(Request $request)
    {
        $routeId = $request->get('routeId');
       // dd($routeId);
        $routeId = implode(", ", $routeId);
        $deliveryDate = $request->get('deliveryDate');
        $dateTo = $request->get('dateTo');

        $OrderType = $request->get('OrderType');
        $status = $request->get('status');

        $getInvoicesOnRoute = DB::connection('sqlsrv3')
            ->select("EXEC spGetStopsToSort '" . $deliveryDate . "','".$dateTo."'," . $OrderType . ",'" . $routeId."','".$status."'" );
        // echo "EXEC spGetStopsToSort '" . $deliveryDate . "'," . $OrderType . "," . $routeId.",'".$status."'";

        return response()->json($getInvoicesOnRoute);
    }
	    public function notifypickers(Request $request)
    {
        $routeId = $request->get('routeId');
        // dd($routeId);
        $routeId = implode(", ", $routeId);
        $deliveryDate = $request->get('deliveryDate');
        $dateTo = $request->get('dateTo');

        $OrderType = $request->get('OrderType');
        $orderTypename =DB::connection('sqlsrv3')->table('tblOrderTypes')->where('OrderTypeId', $OrderType)->first();
        $routeName =DB::connection('sqlsrv3')->table('tblRoutes')->where('RouteId', $routeId)->first();
         //var_dump($orderTypename->OrderType);


           $getInvoicesOnRoute = DB::connection('sqlsrv3')
            ->statement("EXEC spCreateNotifications " . $routeId . ",".$OrderType.",'".$dateTo."'" );
         //echo "EXEC spGetStopsToSort '" . $deliveryDate . "','".$dateTo."'," . $OrderType . ",'" . $routeId."'";
		 $datar = $routeName->Route.' Route No '.$orderTypename->OrderType .' For '.$dateTo;
        $returns = "";
        $returns = $this->slackUser($orderTypename->OrderType,$routeName->Route,$dateTo);
//spCreateNotifications
        return response()->json($datar);
    }

	 public function slackUser($ordertype,$route,$delvirateDate)
    {
        //dd("TEST");
        $url = "https://hooks.slack.com/services/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";
        try {


            $client = new Client();

			//$route = str_replace(' ', '%20', $route);
			//$ordertype = str_replace(' ', '%20', $ordertype);
			$message ="Please Check ". $route." ".$ordertype." For ".$delvirateDate ;

            $request = $client->post($url, ['body' => json_encode(
                [
                    'text' => $message ,

                ]
            )]);
        } catch (Exception $e) {
            exit();
        }
        $stream = $request->getBody()->getContents();
        return $stream;
    }
    public function routePlannerPrintPreview($deliveryDate,$dateTo,$OrderType,$routeId,$status)
    {

       // $routeId = implode(", ", $routeId);
        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('Routeid',$routeId)->get();
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->where('OrderTypeId',$OrderType)->get();
        $getInvoicesOnRoute = DB::connection('sqlsrv3')
            //->select("EXEC spGetStopsToSort '" . $deliveryDate . "','".$dateTo."'," . $OrderType . ",'" . $routeId."','".$status."'" );
            ->select("EXEC spGetStopsToSortPrintPreview '" . $deliveryDate . "','".$dateTo."'," . $OrderType . ",'" . $routeId."','".$status."'" );

        return view('dims/print_preview')
            ->with('routes',$getRoutes)
            ->with('OrderTypes',$deliverTypes)
            ->with('dateRouting',$deliveryDate)
            ->with('stops',$getInvoicesOnRoute);
    }
    public function spTabletLoading($orderId)
    {
        $getRouteProducts = DB::connection('sqlsrv3')
            ->select("EXEC spTabletLoading " . $orderId );
        //echo "EXEC spGetStopsToSort '" . $deliveryDate . "'," . $OrderType . "," . $routeId ;

        return view('dims/miniorderform_tablet')->with('orderId',$orderId)
            ->with('products',$getRouteProducts);
    }
    public function getTruckControlIDInvoices()
    {

    }
    public function returnOrderLineOnSearch(Request $request)
    {
        $searchTheInoice = $request->get('searchTheInoice');
        $getSearchTheInoice = DB::connection('sqlsrv3')
            ->select("EXEC spGetTruckControlDataBySearchUsingOrder '" . $searchTheInoice."'" );
        return response()->json($getSearchTheInoice);
    }

    public function routeplanner()
    {
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        $trucks = DB::connection('sqlsrv3')->table('tblTrucks')->select('TruckName','TruckId','RegNo')->orderBy('TruckName','ASC')->get();
        $tblDrivers = DB::connection('sqlsrv3')->table('tblDrivers')->select('DriverName','DriverId')->orderBy('DriverName','ASC')->get();
        $getDeliveryDates = DB::connection('sqlsrv3')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();
        //$truckControlIds = DB::connection('sqlsrv3')->table('viewRecentTruckControlIds')->select('TruckControlId','Route')->orderBy('TruckControlId', 'desc')->get();
        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();

        return view('dims/route_planner')->with('routes',$getRoutes)->with('trucks',$trucks)->with('drivers',$tblDrivers)
            ->with('orderTypes',$deliverTypes)->with('delivDates',$getDeliveryDates);
    }
    public function routePlannerExt()
    {
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        $trucks = DB::connection('sqlsrv3')->table('tblTrucks')->select('TruckName','TruckId','RegNo')->orderBy('TruckName','ASC')->get();
        $tblDrivers = DB::connection('sqlsrv3')->table('tblDrivers')->select('DriverName','DriverId')->orderBy('DriverName','ASC')->get();
        $getDeliveryDates = DB::connection('sqlsrv3')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();
        //$truckControlIds = DB::connection('sqlsrv3')->table('viewRecentTruckControlIds')->select('TruckControlId','Route')->orderBy('TruckControlId', 'desc')->get();
        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();

        return view('dims/route_planner_ext')->with('routes',$getRoutes)->with('trucks',$trucks)->with('drivers',$tblDrivers)
            ->with('orderTypes',$deliverTypes)->with('delivDates',$getDeliveryDates);
    }
    public function routePlannerExtParam($delvDate,$orderType,$route,$status)
    {
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        $deliverTypeSelected = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->where('OrderTypeId',$orderType)->get();
        $trucks = DB::connection('sqlsrv3')->table('tblTrucks')->select('TruckName','TruckId','RegNo')->orderBy('TruckName','ASC')->get();
        $tblDrivers = DB::connection('sqlsrv3')->table('tblDrivers')->select('DriverName','DriverId')->orderBy('DriverName','ASC')->get();
        $getDeliveryDates = DB::connection('sqlsrv3')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();

        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();
        $getSelectedRoute =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('Routeid',$route)->get();

        return view('dims/route_planner_params')
            ->with('routes',$getRoutes)
            ->with('routeSelected',$getSelectedRoute)
            ->with('trucks',$trucks)->with('drivers',$tblDrivers)
            ->with('orderTypes',$deliverTypes)
            ->with('orderTypeSelected',$deliverTypeSelected)
            ->with('selectedDelivDate',$delvDate)
            ->with('status',$status)
            ->with('delivDates',$getDeliveryDates);
    }
	public function routePlannerExtParamDrivers($delvDate,$orderType,$route,$status)
    {
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        $deliverTypeSelected = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->where('OrderTypeId',$orderType)->get();
        $trucks = DB::connection('sqlsrv3')->table('tblTrucks')->select('TruckName','TruckId','RegNo')->orderBy('TruckName','ASC')->get();
        $tblDrivers = DB::connection('sqlsrv3')->table('tblDrivers')->select('DriverName','DriverId')->orderBy('DriverName','ASC')->get();
        $getDeliveryDates = DB::connection('sqlsrv3')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();

        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();
        $getSelectedRoute =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('Routeid',$route)->get();

        return view('dims/route_sorting_drivers')
            ->with('routes',$getRoutes)
            ->with('routeSelected',$getSelectedRoute)
            ->with('trucks',$trucks)->with('drivers',$tblDrivers)
            ->with('orderTypes',$deliverTypes)
            ->with('orderTypeSelected',$deliverTypeSelected)
            ->with('selectedDelivDate',$delvDate)
            ->with('status',$status)
            ->with('delivDates',$getDeliveryDates);
    }
    public function getRouteDifference(Request $request)
    {
        $dateFrom = $request->get('dateFrom');
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d');
        $getOrdersOnWrongRoute = DB::connection('sqlsrv3')
            ->select("EXEC spOrdersOnWrongRoute '" . $dateFrom."'" );
        //dd("EXEC spOrdersOnWrongRoute " . $dateFrom );
        $output['recordsTotal'] = count($getOrdersOnWrongRoute);
        $output['data'] = $getOrdersOnWrongRoute;
        $output['recordsFiltered'] = $output['recordsTotal'];

        $output['draw'] = intval($request->input('draw'));

        return $output;


    }
    public function ordersNotOnDefaultRoutes()
    {
        $delDate = (new \DateTime())->format('Y-m-d');
        return view('dims/orders_on_routes')->with('delvDate',$delDate);
    }
    public function truckControlId(Request $request)
    {
        $term = $request->get('term','');;

        $results = array();
        $queries =DB::connection('sqlsrv3')->table("viewTruckControlFilters")->select('TruckControlId','Route','TruckName','DriverName','DeliveryDate','TruckId','DriverId','Assistant','AssistantID','DateCreated')
            ->where('TruckControlId', 'LIKE', '%'.$term.'%')->distinct()->orderBy('TruckControlId', 'desc')
            ->take(10)->get();
        foreach ($queries as $query)
        {
            $results[] =  ['TruckControlId' => $query->TruckControlId,'Route'=>$query->Route,'TruckName'=>$query->TruckName,
                'TruckId'=>$query->TruckId,'DriverName'=>$query->DriverName,'DriverId'=>$query->DriverId,'DeliveryDate'=>$query->DeliveryDate,
                'AssistantID'=>$query->AssistantID,'Assistant'=>$query->Assistant,'DateCreated'=>$query->DateCreated];
        }
        if(count($results))
            return $results;
        else
            return ['value'=>'No Result Found','id'=>''];
    }
    public function truckControlFromDate(Request $request)
    {
        $term = $request->get('deliveryDate');

        $results = array();
        $queries =DB::connection('sqlsrv3')->table("viewTruckControlFilters")->select('TruckControlId','Route','TruckName','DriverName','DeliveryDate','TruckId','DriverId','Assistant','AssistantID','DateCreated')
            ->where('TruckControlId',$term)->distinct()->orderBy('TruckControlId', 'desc')
            ->take(10)->get();
        foreach ($queries as $query)
        {
            $results[] =  ['TruckControlId' => $query->TruckControlId,'Route'=>$query->Route,'TruckName'=>$query->TruckName,
                'TruckId'=>$query->TruckId,'DriverName'=>$query->DriverName,'DriverId'=>$query->DriverId,'DeliveryDate'=>$query->DeliveryDate,
                'AssistantID'=>$query->AssistantID,'Assistant'=>$query->Assistant,'DateCreated'=>$query->DateCreated];
        }
        if(count($results))
            return $results;
        else
            return ['value'=>'No Result Found','id'=>''];
    }
    public function truckControlSheetDetails(Request $request)
    {
        $truckControlID = $request->get('truckControlID');
        $getTruckControlSheetDetails = DB::connection('sqlsrv3')
            ->select("EXEC spGetTruckControlSheetDetails " . $truckControlID );
        return response()->json($getTruckControlSheetDetails);
    }

    public function routeplannermap()
    {
        return view('dims/mapview');
    }
    public function testTruckSheetView($truckControlID)
    {
        //$truckControlID = $request->get('truckControlID');

        $getTruckControlSheetDetails = DB::connection('sqlsrv3')
            ->select("EXEC spTruckControlDeliveryReport " . $truckControlID );
        $getTruckControlSheetHeader = DB::connection('sqlsrv3')
            ->select("EXEC spTruckSheetHeader " . $truckControlID );
        $getTruckControlSheetFooter = DB::connection('sqlsrv3')
            ->select("EXEC spTruckSheetFooter " . $truckControlID );
        // dd($getTruckControlSheetHeader[0]);
        return view('dims/trucksheet')->with('trucksheetdata',$getTruckControlSheetDetails)
            ->with('truckSheetHeader',$getTruckControlSheetHeader)
            ->with('truckSheetFooter',$getTruckControlSheetFooter);
    }
    public function getTruckControlSheetHeaderByTruckId(Request $request)
    {
        $truckControlID = $request->get('truckControlID');

        $getTruckControlSheetHeader = DB::connection('sqlsrv3')
            ->select("EXEC spTruckSheetHeader " . $truckControlID );
        return response()->json($getTruckControlSheetHeader);

    }
    public function moveTheOrder(Request $request)
    {
        $orderId = $request->get('orderId');
        $routeId = $request->get('routeId');
        $orderTypeId = $request->get('orderTypeId');

        DB::connection('sqlsrv3')->table('tblOrders')
            ->where('OrderId', $orderId)->
            update(['LateOrder' => $orderTypeId,'RouteId'=>$routeId,'DeliverySequence'=>0]);
        echo $orderId;
    }
    public function moveTheOrderArray(Request $request)
    {
        $orderId = $request->get('orderId');
        $routeId = $request->get('routeId');
        $orderTypeId = $request->get('orderTypeId');
        $delivDate= $request->get('delivDate');
//
        foreach ($orderId as $value) {

            /*DB::connection('sqlsrv3')->table('tblOrders')
                ->where('OrderId', $value['orderId'])->
                update(['LateOrder' => $orderTypeId, 'RouteId' => $routeId,
                    'DeliverySequence' => 0,'DeliveryDate'=>$delivDate]);*/
            $getTruckControlSheetDetails = DB::connection('sqlsrv3')
                ->statement("EXEC spMoveOrder " . $value['orderId'].",'".$delivDate."',".$routeId.",".$orderTypeId);
        }
    }
    public function updateTruckControlSheetHeaderByTruckId(Request $request)
    {
        //new \DateTime($request->get('delivDate')))->format('Y-m-d H:m:s')
        $truckControlID = $request->get('truckControlID');
        $truckName = $request->get('truckName');
        $driver = $request->get('driver');
        $assistant = $request->get('assistant');
        $dateCreateForControlSheet =(new \DateTime($request->get('dateCreateForControlSheet')))->format('Y-m-d H:m:s') ;
        $delvDateForControlSheet =  (new \DateTime($request->get('delvDateForControlSheet')))->format('Y-m-d H:m:s');
        $getTruckControlSheetHeader = DB::connection('sqlsrv3')->
        table('tblTruckControlSheets')
            ->where('TruckControlId', $truckControlID)
            ->update(['DateCreated' => $dateCreateForControlSheet,'DeliveryDate' => $delvDateForControlSheet,
                'TruckId' => $truckName,'DriverId' => $driver,'AssistantID' => $assistant]);
        return response()->json($getTruckControlSheetHeader);

    }
    public function jllSearchEngine(Request $request)
    {
        $search= $request->get('search');
    }
    public function geoJson()
    {
        //sqlsrv3
        $coord = DB::connection('sqlsrv3')
            ->select("SELECT distinct top 5
                      [Longitude]
                      ,[Lattitude],'STORE' as StoreName
                      FROM [LinxBriefcase].[dbo].[AuditTrail]
                      where UserName not in('Reginald','Paul Baillie')");
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => array()
        );
        foreach ($coord as $value) {
            $feature = array(
                'type' => 'Feature',
                'geometry' => array(
                    'type' => 'Point',
                    # Pass Longitude and Latitude Columns here
                    'coordinates' => array($value->Longitude, $value->Lattitude)
                ),
                # Pass other attribute columns here
                'properties' => array(
                    'title' => $value->StoreName,
                    'description' => $value->StoreName,
                    'marker-color' => "#ff00ff",
                    'marker-size' => "large",
                    'marker-symbol' => "rocket"
                )
            );
            array_push($geojson['features'], $feature);
        }
        return response()->json($geojson);
    }

    public function drone()
    {
        $drone = DB::connection('sqlsrv3')
            ->select("Select top 1 * from tblDriversCoord order by tmtTimestamp desc ");
        //Testing
        /*  $drone = DB::connection('sqlsrv3')
              ->select("SELECT TOP 1 PERCENT *
    FROM [LinxBriefcase].[dbo].[AuditTrail]
    ORDER BY NEWID()");*/

        $geojson = array();
        $obj = json_encode(array(),JSON_FORCE_OBJECT);
        foreach ($drone as $value) {
            $feature = array(
                'type' => 'Feature',
                'geometry' => array(
                    'type' => 'Point',
                    # Pass Longitude and Latitude Columns here
                    'coordinates' => array($value->lon, $value->lat)
                    // 'coordinates' => array($value->Longitude, $value->Lattitude)
                ),
                # Pass other attribute columns here
                'properties' => json_decode ("{}")
            );
            array_push($geojson, $feature);

        }
        return response()->json($geojson[0]);
    }
	 public function liveBulkPicking()
    {
        $Date = (new \DateTime())->format('Y-m-d');

		//dd($Date);
        $livebulk = DB::connection('sqlsrv3')
            ->select("EXEC spBulkPickingLiveGrid '" .$Date."'");

        //dd($livebulk);
        return view('dims/bulkpickingperformance')
            ->with('performance',$livebulk);


    }
	    public function designPickingInformationPerTeam($deldate,$routeid,$ordertype)
    {
        $routes = DB::connection('sqlsrv3')
            ->select("Select Route,Routeid from tblRoutes Order by CASE WHEN (Route ='".$routeid."'  ) THEN 1 ELSE 2 END, [Route]");

        $ordetdyType = DB::connection('sqlsrv3')
            ->select("Select OrderTypeid ,OrderType from tblOrderTypes  Order by CASE WHEN (OrderType = '".$ordertype."' ) THEN 1 ELSE 2 END, OrderTypeid ");
        $dept = DB::connection('sqlsrv3')
            ->select("SELECT * from tblPickingDepartments");

        return view('dims/individiualstatuspertteam')
            ->with('routes',$routes)
            ->with('deldate',$deldate)
            ->with('dept',$dept)
            ->with('ordertypes',$ordetdyType);
    }
    public function retrieve($deldate,$routeid,$ordertype)
    {
        //dd("SELECT * from fnOrderedVsPicked('$deldate',$routeid,$ordertype)");

        $fnOrderdVsPicked = DB::connection('sqlsrv3')
            ->select("SELECT * from fnOrderedVsPicked('$deldate',$ordertype,$routeid)");
        return response()->json($fnOrderdVsPicked);
    }
	public function liveFleetDeliveries()
    {
        $Date = (new \DateTime())->format('Y-m-d');
      //  $Date='2019-07-05';
        $livebulk = DB::connection('sqlsrv3')
            ->select("EXEC spDriverLiveFleetFeed '" . $Date . "'");

        //dd($livebulk);
        return view('dims/driverlivefleet')
            ->with('performance', $livebulk)->with('delDate', $Date);
    }
    public function driverFleetInfo($deldate,$routename,$ordertype)
    {

        $driversondutyStops=  DB::connection('sqlsrv3')
            ->select("EXEC spLiveDriversAppInfo '".$deldate."','".$routename."','".$ordertype."'");

        return view('dims/individual_driver_deliveries_status')
            ->with('stops', $driversondutyStops);

    }
	   public function logisticsPlan($dates)
    {
        $Date = (new \DateTime($dates))->format('Y-m-d');
          //$Date='2019-07-05';
        $livebulk = DB::connection('sqlsrv3')
            ->select("EXEC spLogisticsPlan '" . $Date . "'");

        $livePalnned = DB::connection('sqlsrv3')
            ->select("EXEC spLogisticsPlannedRoutes '" . $Date . "'");

        //dd($livebulk);
        return view('dims/logisticsPlan')
            ->with('performance', $livebulk)->with('delDate', $Date)->with('planned',$livePalnned);
    }
    public function LogisticsInsertMapRoute($deldateRoutingid,$ordertype,$route)
    {

        $oTypes=  DB::connection('sqlsrv3')
            ->select("select * from tblOrdertypes (nolock) order by ordertypeid");

        $routes=  DB::connection('sqlsrv3')
            ->select("select * from tblRoutes (nolock) order by route");
        $drivers=  DB::connection('sqlsrv3')
            ->select("select * from tblDrivers (nolock) order by DriverName");
        $tblDispatchLocations =  DB::connection('sqlsrv3')
            ->select("select * from tblDispatchLocations (nolock)");

        $trucks =  DB::connection('sqlsrv3')
            ->select("select * from tblTrucks (nolock) order by RegNo");
			   $routinginfo =  DB::connection('sqlsrv3')
            ->select("select cast(DeliveryDate as date ) as DeliveryDate,r.Route,ot.OrderType from tblDeliveryDateRouting (nolock) tdd
inner join tblRoutes(nolock) r
on r.Routeid = tdd.RouteId
inner join tblOrderTypes (nolock) ot
on ot.OrderTypeId = tdd.OrderTypeId
 where DeliveryDateRoutingID = $deldateRoutingid");

        return view('dims/individual_plan_routes')
            ->with('otypes', $oTypes)
            ->with('routes', $routes)
            ->with('drivers', $drivers)
            ->with('dispatch', $tblDispatchLocations)
            ->with('trucks', $trucks)
            ->with('ot', $ordertype)
            ->with('route', $route)
			 ->with('routinginfo', $routinginfo)
            ->with('routingId', $deldateRoutingid)
            ;

    }
    public function updatelogisticsinformation(Request $request)
    {
        //update here
        $routingid = $request->get('routingid');
        $driverid = $request->get('driverid');
        $assistantid = $request->get('assistantid');
        $truckid = $request->get('truckid');
        $dispatchid = $request->get('dispatchid');

       // dd($routingid);

        DB::connection('sqlsrv3')->table('tblDeliveryDateRouting')
            ->where('DeliveryDateRoutingID',$routingid )
            ->update(['DriverId' => $driverid,'TruckId'=>$truckid,'intDispatchId'=>$dispatchid,'AssistantId'=>$assistantid]);
    }
	 public function driverreq_report()
    {
        return view('dims/drivers_requisitions');
    }
    public function driverreq_reportJson($datefrom,$dateTo)
    {
        $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
            ->select("EXEC spDriversAppRequisitionReport '".$datefrom."','".$dateTo."'");
        return response()->json($gridcustomerjsonspecials);

    }
	public function driverreq_perrouteJson($routingid)
    {
        $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
            ->select("EXEC spDriversAppRequisitionPerRoute ".$routingid);
        return response()->json($gridcustomerjsonspecials);

    }
}
