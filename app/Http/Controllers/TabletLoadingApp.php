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
//use App\Http\Co
use Auth;

class TabletLoadingApp extends Controller
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
            if (strlen($value['orderId']) > 1) {
                $sequence = DB::connection('sqlsrv4')
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
        $updateSort = $request->get('updateSort');
        $truckControlKeeper = $request->get('truckControlKeeper');
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
                if (strlen($value['orderId']) > 1) {
                    $sequence2 = DB::connection('sqlsrv3')
                        ->select("EXEC spUpdateOrderDeliverySequence " . $value['orderId'] . "," . $value['index'] . "," . $truckControlKeeper);
                    $array2[$j] = $sequence2;
                }

                $j++;
            }
        }
        $outPut['updateSort'] = count($array2);
        $outPut['unsequenced'] = count($array);
        $outPut['truckId'] = $truckControlKeeper;
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
        //old
        /*$routeId = $request->get('routeId');
        $routeId = implode(", ", $routeId);
        $deliveryDate = $request->get('deliveryDate');
        $orderIDs = DB::connection('sqlsrv4')->table('tblOrderTypes')->select('OrderTypeId')->get();
        $OrderType = $request->get('OrderType');
        $status = $request->get('status');
        $getInvoicesOnRoute = DB::connection('sqlsrv4')
            ->select("EXEC spGetStopsToSort '" . $deliveryDate . "'," . $OrderType . ",'" . $routeId . "','" . $status . "'");
        return response()->json($getInvoicesOnRoute);*/
    }

    public function spTabletLoading($orderId)
    {

        $getRouteProducts = DB::connection('sqlsrv4')
            ->select("EXEC spTabletLoading " . $orderId);
        //echo "EXEC spGetStopsToSort '" . $deliveryDate . "'," . $OrderType . "," . $routeId ;


        return view('dims/miniorderform_tablet')->with('orderId', $orderId)
            ->with('products', $getRouteProducts);
    }

    public function routePlannerPrintPreview($deliveryDate, $dateTo, $OrderType, $routeId, $status)
    {

        // $routeId = implode(", ", $routeId);
        $getRoutes = DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('Routeid', $routeId)->get();
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId', 'OrderType')->where('OrderTypeId', $OrderType)->get();
        $getInvoicesOnRoute = DB::connection('sqlsrv3')
            //->select("EXEC spGetStopsToSort '" . $deliveryDate . "','".$dateTo."'," . $OrderType . ",'" . $routeId."','".$status."'" );
            ->select("EXEC spGetStopsToSortPrintPreview '" . $deliveryDate . "','" . $dateTo . "'," . $OrderType . ",'" . $routeId . "','" . $status . "'");

        return view('dims/print_preview')
            ->with('routes', $getRoutes)
            ->with('OrderTypes', $deliverTypes)
            ->with('dateRouting', $deliveryDate)
            ->with('stops', $getInvoicesOnRoute);
    }

    public function updateTableLoadingAppProducts(Request $request)
    {

        //orderDetails
        $array = array();
        $orderDetails = $request->get('orderDetails');
        $OrderId = $request->get('OrderId');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;

        $getRouteProducts = DB::connection('sqlsrv4')
            ->select("EXEC spXMLUpdateLoadingAPPVal " . $OrderId . ",'" . $this->toxml($orderDetails, "xml", array("result")) . "'," . $userid . "," . $userName);


        $outPut['Result'] = $getRouteProducts[0]->Result;
        if ($getRouteProducts[0]->statements == "close") {
            $outPut['statements'] = "CLOSE";
        } else {
            $outPut['statements'] = "REPRINT";
        }
        //  dd($outPut);
        return response()->json($outPut);
    }


    private static function getTabs($tabcount)
    {
        $tabs = '';
        for ($i = 0; $i < $tabcount; $i++) {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = Array(), $tabcount = 0)
    {
        $result = '';
        $tabs = self::getTabs($tabcount);
        foreach ($arr as $key => $val) {
            $element = isset($elements[0]) ? $elements[0] : $key;
            $result .= $tabs;
            $result .= "<" . $element . ">";
            if (!is_array($val))
                $result .= $val;
            else {
                $result .= "\r\n";
                $result .= self::asxml($val, array_slice($elements, 1, true), $tabcount + 1);
                $result .= $tabs;
            }
            $result .= "</" . $element . ">\r\n";
        }
        return $result;
    }

    public static function toxml($arr, $root = "xml", $elements = Array())
    {
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }

    public function getTruckControlIDInvoices()
    {

    }

    public function returnOrderLineOnSearch(Request $request)
    {
        $searchTheInoice = $request->get('searchTheInoice');
        $getSearchTheInoice = DB::connection('sqlsrv3')
            ->select("EXEC spGetTruckControlDataBySearchUsingOrder '" . $searchTheInoice . "'");
        return response()->json($getSearchTheInoice);
    }

    public function routeplanner()
    {
        $GroupId = Auth::user()->GroupId;
        $things = (new SalesForm())->getThings($GroupId, 'Allow Call Logger');
        $deliverTypes = DB::connection('sqlsrv4')->table('tblOrderTypes')->select('OrderTypeId', 'OrderType')->get();
        $trucks = DB::connection('sqlsrv4')->table('tblTrucks')->select('TruckName', 'TruckId', 'RegNo')->orderBy('TruckName', 'ASC')->get();
        $tblDrivers = DB::connection('sqlsrv4')->table('tblDrivers')->select('DriverName', 'DriverId')->orderBy('DriverName', 'ASC')->get();
        $getDeliveryDates = DB::connection('sqlsrv4')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();
        //$truckControlIds = DB::connection('sqlsrv3')->table('viewRecentTruckControlIds')->select('TruckControlId','Route')->orderBy('TruckControlId', 'desc')->get();
        $getRoutes = DB::connection('sqlsrv4')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse', '0')->orderBy('Route', 'asc')->get();

        return view('dims/route_planner')->with('routes', $getRoutes)->with('trucks', $trucks)->with('drivers', $tblDrivers)
            ->with('orderTypes', $deliverTypes)->with('delivDates', $getDeliveryDates)->with('things', $things);
    }

    public function routePlannerExt()
    {
        $deliverTypes = DB::connection('sqlsrv4')->table('tblOrderTypes')->select('OrderTypeId', 'OrderType')->get();
        $trucks = DB::connection('sqlsrv4')->table('tblTrucks')->select('TruckName', 'TruckId', 'RegNo')->orderBy('TruckName', 'ASC')->get();
        $tblDrivers = DB::connection('sqlsrv4')->table('tblDrivers')->select('DriverName', 'DriverId')->orderBy('DriverName', 'ASC')->get();
        $getDeliveryDates = DB::connection('sqlsrv4')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();
        //$truckControlIds = DB::connection('sqlsrv3')->table('viewRecentTruckControlIds')->select('TruckControlId','Route')->orderBy('TruckControlId', 'desc')->get();
        $getRoutes = DB::connection('sqlsrv4')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse', '0')->orderBy('Route', 'asc')->get();

        return view('dims/route_planner_ext')->with('routes', $getRoutes)->with('trucks', $trucks)->with('drivers', $tblDrivers)
            ->with('orderTypes', $deliverTypes)->with('delivDates', $getDeliveryDates);
    }

    public function routePlannerExtParam($delvDate, $orderType, $route, $status)
    {
        $GroupId = Auth::user()->GroupId;
        $things = (new SalesForm())->getThings($GroupId, 'Allow Call Logger');
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        $deliverTypeSelected = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->where('OrderTypeId',$orderType)->get();
        $trucks = DB::connection('sqlsrv3')->table('tblTrucks')->select('TruckName','TruckId','RegNo')->orderBy('TruckName','ASC')->get();
        $tblDrivers = DB::connection('sqlsrv3')->table('tblDrivers')->select('DriverName','DriverId')->orderBy('DriverName','ASC')->get();
        $getDeliveryDates = DB::connection('sqlsrv3')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();

        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();
        $getSelectedRoute =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('Routeid',$route)->get();
        $DocDateTime = (new \DateTime())->format('Y-m-d');
        return view('dims/route_planner_params')
            ->with('routes',$getRoutes)
            ->with('routeSelected',$getSelectedRoute)
            ->with('trucks',$trucks)->with('drivers',$tblDrivers)
            ->with('orderTypes',$deliverTypes)
            ->with('orderTypeSelected',$deliverTypeSelected)
            ->with('selectedDelivDate',$DocDateTime)
            ->with('status',$status)
            ->with('delivDates',$getDeliveryDates);
    }

    public function getRouteDifference(Request $request)
    {
        $dateFrom = $request->get('dateFrom');
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d');
        $getOrdersOnWrongRoute = DB::connection('sqlsrv3')
            ->select("EXEC spOrdersOnWrongRoute '" . $dateFrom . "'");
        //dd("EXEC spOrdersOnWrongRoute " . $dateFrom );
        $output['recordsTotal'] = count($getOrdersOnWrongRoute);
        $output['data'] = $getOrdersOnWrongRoute;
        $output['recordsFiltered'] = $output['recordsTotal'];

        $output['draw'] = intval($request->input('draw'));

        return $output;


    }

    public function invoicesnotprinting()
    {
        $notPrinted = DB::connection('sqlsrv3')->select("SELECT * FROM viewSalesInvoiceHeader where intflag <>1");
        $credits = DB::connection('sqlsrv3')->select("SELECT * FROM viewCreditHeaders where intflag <>1");
        $middleLayerInvoiceVsDims = DB::connection('sqlsrv3')->select("SELECT * FROM viewInvoicesNotGoingThrough Order by DeliveryDate "); //Added for MS

        return view('dims/invoicesnotprinting')
            ->with('credits', $credits)
            ->with('middlelayer', $middleLayerInvoiceVsDims)
            ->with('notprinted', $notPrinted);
    }

    public function forceinvoicetoprint(Request $request)
    {
        $invNumber = $request->get('invNumber');

        foreach ($invNumber as $value) {

            DB::connection('sqlsrv3')
                ->statement("EXEC spForceInvoicesToAccounting '" . $value['invNumber'] . "'");

        }
    }

//Added at MS
    public function updateIQInvoices(Request $request)
    {
        $OrderId = $request->get('OrderId');

        foreach ($OrderId as $value) {
            DB::connection('sqlsrv3')
                ->statement("exec spUpdateTotalsAndInvoiceNumberFromIQ " . $value['OrderId']);
        }
    }

    public function forcecredits(Request $request)
    {
        $invNumber = $request->get('invNumber');

        foreach ($invNumber as $value) {

            DB::connection('sqlsrv3')
                ->statement("EXEC spForceInvoicesToAccounting '" . $value['invNumber'] . "'");

        }
    }

    public function ordersNotOnDefaultRoutes()
    {
        $delDate = (new \DateTime())->format('Y-m-d');
        return view('dims/orders_on_routes')->with('delvDate', $delDate);
    }

    public function truckControlId(Request $request)
    {
        $term = $request->get('term', '');;

        $results = array();
        $queries = DB::connection('sqlsrv3')->table("viewTruckControlFilters")->select('TruckControlId', 'Route', 'TruckName', 'DriverName', 'DeliveryDate', 'TruckId', 'DriverId', 'Assistant', 'AssistantID', 'DateCreated')
            ->where('TruckControlId', 'LIKE', '%' . $term . '%')->distinct()->orderBy('TruckControlId', 'desc')
            ->take(10)->get();
        foreach ($queries as $query) {
            $results[] = ['TruckControlId' => $query->TruckControlId, 'Route' => $query->Route, 'TruckName' => $query->TruckName,
                'TruckId' => $query->TruckId, 'DriverName' => $query->DriverName, 'DriverId' => $query->DriverId, 'DeliveryDate' => $query->DeliveryDate,
                'AssistantID' => $query->AssistantID, 'Assistant' => $query->Assistant, 'DateCreated' => $query->DateCreated];
        }
        if (count($results))
            return $results;
        else
            return ['value' => 'No Result Found', 'id' => ''];
    }

    public function truckControlFromDate(Request $request)
    {
        $term = $request->get('deliveryDate');

        $results = array();
        $queries = DB::connection('sqlsrv3')->table("viewTruckControlFilters")->select('TruckControlId', 'Route', 'TruckName', 'DriverName', 'DeliveryDate', 'TruckId', 'DriverId', 'Assistant', 'AssistantID', 'DateCreated')
            ->where('TruckControlId', $term)->distinct()->orderBy('TruckControlId', 'desc')
            ->take(10)->get();
        foreach ($queries as $query) {
            $results[] = ['TruckControlId' => $query->TruckControlId, 'Route' => $query->Route, 'TruckName' => $query->TruckName,
                'TruckId' => $query->TruckId, 'DriverName' => $query->DriverName, 'DriverId' => $query->DriverId, 'DeliveryDate' => $query->DeliveryDate,
                'AssistantID' => $query->AssistantID, 'Assistant' => $query->Assistant, 'DateCreated' => $query->DateCreated];
        }
        if (count($results))
            return $results;
        else
            return ['value' => 'No Result Found', 'id' => ''];
    }

    public function truckControlSheetDetails(Request $request)
    {
        $truckControlID = $request->get('truckControlID');
        $getTruckControlSheetDetails = DB::connection('sqlsrv3')
            ->select("EXEC spGetTruckControlSheetDetails " . $truckControlID);
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
            ->select("EXEC spTruckControlDeliveryReport " . $truckControlID);
        $getTruckControlSheetHeader = DB::connection('sqlsrv3')
            ->select("EXEC spTruckSheetHeader " . $truckControlID);
        $getTruckControlSheetFooter = DB::connection('sqlsrv3')
            ->select("EXEC spTruckSheetFooter " . $truckControlID);
        // dd($getTruckControlSheetHeader[0]);
        return view('dims/trucksheet')->with('trucksheetdata', $getTruckControlSheetDetails)
            ->with('truckSheetHeader', $getTruckControlSheetHeader)
            ->with('truckSheetFooter', $getTruckControlSheetFooter);
    }

    public function getTruckControlSheetHeaderByTruckId(Request $request)
    {
        $truckControlID = $request->get('truckControlID');

        $getTruckControlSheetHeader = DB::connection('sqlsrv3')
            ->select("EXEC spTruckSheetHeader " . $truckControlID);
        return response()->json($getTruckControlSheetHeader);

    }

    public function moveTheOrder(Request $request)
    {
        $orderId = $request->get('orderId');
        $routeId = $request->get('routeId');
        $orderTypeId = $request->get('orderTypeId');


        DB::connection('sqlsrv4')->table('tblOrders')
            ->where('OrderId', $orderId)->
            update(['LateOrder' => $orderTypeId, 'RouteId' => $routeId, 'DeliverySequence' => 0]);

        //management console
        echo $orderId;
    }

    public function moveTheOrderArray(Request $request)
    {

        $userid = \Illuminate\Support\Facades\Auth::user()->UserID;
        $userName = \Illuminate\Support\Facades\Auth::user()->UserName;

        $orderId = $request->get('orderId');
        $routeId = $request->get('routeId');
        $orderTypeId = $request->get('orderTypeId');
        $delivDate= (new \DateTime($request->get('delivDate')))->format('Y-m-d');
//
        foreach ($orderId as $value) {

            /*DB::connection('sqlsrv3')->table('tblOrders')
                ->where('OrderId', $value['orderId'])->
                update(['LateOrder' => $orderTypeId, 'RouteId' => $routeId,
                    'DeliverySequence' => 0,'DeliveryDate'=>$delivDate]);*/
            $getTruckControlSheetDetails = DB::connection('sqlsrv3')
                ->statement("EXEC spMoveOrder " . $value['orderId'].",'".$delivDate."',".$routeId.",".$orderTypeId.",".$userid.",'".$userName."'");
        }

    }

    public function sequenceOrdersByMode(Request $request)
    {
        $mode = $request->get('mode');
        $orderId = $request->get('orderId');
        $seq = $request->get('seq');

        $returnNewSeq = DB::connection('sqlsrv3')
            ->select('exec spIncrementDeliverySequence ?,?,?',
                array($mode, $orderId, $seq)
            );
        return response()->json($returnNewSeq);
    }

    public function resequenceOrders(Request $request)
    {
        $deldate = $request->get('deldate');
        $orderType = $request->get('orderType');
        $routeId = $request->get('routeId');

        $returnNewSeq = DB::connection('sqlsrv3')
            ->statement('exec spResequenceDeliverySequence ?,?,?',
                array($deldate, $orderType, $routeId)
            );
        return response()->json($returnNewSeq);
    }

    public function updateTruckControlSheetHeaderByTruckId(Request $request)
    {
        //new \DateTime($request->get('delivDate')))->format('Y-m-d H:m:s')
        $truckControlID = $request->get('truckControlID');
        $truckName = $request->get('truckName');
        $driver = $request->get('driver');
        $assistant = $request->get('assistant');
        $dateCreateForControlSheet = (new \DateTime($request->get('dateCreateForControlSheet')))->format('Y-m-d H:m:s');
        $delvDateForControlSheet = (new \DateTime($request->get('delvDateForControlSheet')))->format('Y-m-d H:m:s');
        $getTruckControlSheetHeader = DB::connection('sqlsrv3')->
        table('tblTruckControlSheets')
            ->where('TruckControlId', $truckControlID)
            ->update(['DateCreated' => $dateCreateForControlSheet, 'DeliveryDate' => $delvDateForControlSheet,
                'TruckId' => $truckName, 'DriverId' => $driver, 'AssistantID' => $assistant]);
        return response()->json($getTruckControlSheetHeader);

    }

    public function jllSearchEngine(Request $request)
    {
        $search = $request->get('search');
    }

    public function geoJson()
    {
        //sqlsrv4
        $coord = DB::connection('sqlsrv4')
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
        /*  $drone = DB::connection('sqlsrv4')
              ->select("SELECT TOP 1 PERCENT *
    FROM [LinxBriefcase].[dbo].[AuditTrail]
    ORDER BY NEWID()");*/

        $geojson = array();
        $obj = json_encode(array(), JSON_FORCE_OBJECT);
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
                'properties' => json_decode("{}")
            );
            array_push($geojson, $feature);

        }
        return response()->json($geojson[0]);
    }

    public function createtripsheet()
    {

        $route = DB::connection('sqlsrv3')
            ->select("Select Route,Routeid from tblRoutes Order by Route");

        $ordertype = DB::connection('sqlsrv3')
            ->select("Select OrderType from tblOrderTypes Order by OrderTypeId");

        $drivers = DB::connection('sqlsrv3')
            ->select("Select DriverName from tblDrivers Order by DriverName");

        $trucks = DB::connection('sqlsrv3')
            ->select("Select TruckName from tblTrucks order by TruckName");

        return view('dims/createtripsheet')
            ->with('route', $route)
            ->with('drivers', $drivers)
            ->with('trucks', $trucks)
            ->with('ordertype', $ordertype);
    }

    public function createtripsheetnotes()
    {

        $route = DB::connection('sqlsrv3')
            ->select("Select Route,Routeid from tblRoutes Order by Route");

        $ordertype = DB::connection('sqlsrv3')
            ->select("Select OrderType,OrderTypeId from tblOrderTypes Order by OrderTypeId");


        return view('dims/tripsheet_notes')
            ->with('route', $route)
            ->with('ordertype', $ordertype);
    }

    public function getRoutingIdNotes(Request $request)
    {
        $ordertypeId = $request->get('ordertypeid');
        $routeid = $request->get('routeid');
        $deliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
//strRouteNote

        $routenote = DB::connection('sqlsrv3')
            ->select("SELECT strRouteNote from tblDeliveryDateRouting where routeid = $routeid and ordertypeid = $ordertypeId and DeliveryDate = '$deliveryDate'");

        return response()->json($routenote);

    }
    public function saveRoutingIdNotes(Request $request)
    {
        $ordertypeId = $request->get('ordertypeid');
        $routeid = $request->get('routeid');
        $note = $request->get('note');
       // dd($request->get('deliveryDate'));
        $deliveryDate = (new \DateTime($request->get('deliveryDate')))->format('Y-m-d');
        $userAuthID = \Illuminate\Support\Facades\Auth::user()->UserID;


        $listOfRoutingIds= DB::connection('sqlsrv4')
            ->select('exec spSaveRouteNote ?,?,?,?,?',
                array($ordertypeId,$routeid,$deliveryDate,$userAuthID,$note)
            );

        return response()->json($listOfRoutingIds);

    }

    public function designPickingInformationPerTeam($deldate, $routeid, $ordertype)
    {
        $routes = DB::connection('sqlsrv3')
            ->select("Select Route,Routeid from tblRoutes Order by CASE WHEN (Route ='" . $routeid . "'  ) THEN 1 ELSE 2 END, [Route]");

        $ordetdyType = DB::connection('sqlsrv3')
            ->select("Select OrderTypeid ,OrderType from tblOrderTypes  Order by CASE WHEN (OrderType = '" . $ordertype . "' ) THEN 1 ELSE 2 END, OrderTypeid ");
        $dept = DB::connection('sqlsrv3')
            ->select("SELECT * from tblPickingDepartments");

        return view('dims/individiualstatuspertteam')
            ->with('routes', $routes)
            ->with('deldate', $deldate)
            ->with('dept', $dept)
            ->with('ordertypes', $ordetdyType);
    }

    public function retrieve($deldate, $routeid, $ordertype)
    {
        //dd("SELECT * from fnOrderedVsPicked('$deldate',$routeid,$ordertype)");

        $fnOrderdVsPicked = DB::connection('sqlsrv3')
            ->select("SELECT * from fnOrderedVsPicked('$deldate',$ordertype,$routeid)");
        return response()->json($fnOrderdVsPicked);
    }

    public function liveBulkPicking()
    {
        $Date = (new \DateTime())->format('Y-m-d');
        $livebulk = DB::connection('sqlsrv3')
            ->select("EXEC spBulkPickingLiveGrid ?",array($Date));

        //dd($livebulk);
        $company =  env('COMPANY');
        switch ($company) {
            case "Goodfood Enterprise":
                return view('bulkpicking/bulkpickingperformanceseafood')
                    ->with('performance', $livebulk);
                break;
            case "Foodgistics":
                return view('bulkpicking/bulkpickingperformancefoodgistics')
                    ->with('performance', $livebulk);
                    break;
            case "Kerston Foods":
                return view('bulkpicking/bulkpickingperformancekersonfoods')
                    ->with('performance', $livebulk);
                break;
            // code to execute when expression is equal to value2
            //  break;

            default:
                // code to execute when none of the cases match the expression
                break;
        }
    }
    public function bulkPickingPerUserView()
    {
        return view('dims/bulkpickingperformanceperuser');
    }
    public function bulkPickingPerUserJSON($datefrom,$dateTo)
    {
        $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
            ->select("EXEC spBulkPickingPerformancePerUser '".$datefrom."','".$dateTo."'");
        return response()->json($gridcustomerjsonspecials);
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
    public function routePlannerSuggestions($deliveryDate,$OrderType,$routeId,$status)
    {
        $this->authorize('isAllowCompanyPermission', ['App\Models\CompanyPermission', 'isallowrouteoptomo']);
        $array = array();
        $getInvoicesOnRoute = DB::connection('sqlsrv3')
            ->select("EXEC spGetStopsToOptimize '" . $deliveryDate . "','".$OrderType."'," . $routeId . ",'" . $status."'" );

        foreach ($getInvoicesOnRoute as $val)
        {
            // if(!in_array($val->, $array)){
            $array[]=$val->StoreName;
            // }
        }



        return view('dims/suggestions_routeplan')
            ->with('all',$getInvoicesOnRoute)->with('storenames',$array);
    }
    public function getStopToSortOptimization(Request $request)
    {
        $deliveryDate = $request->get("deliverydata");
        $OrderType = $request->get("orderyype");
        $routeId = $request->get("routeid");
        $status = $request->get("status");
        $getInvoicesOnRoute = DB::connection('sqlsrv3')
            ->select("EXEC spGetStopsToSort '" . $deliveryDate . "','".$OrderType."'," . $routeId . ",'" . $status."'" );
        return response()->json($getInvoicesOnRoute);


    }
    public function driverFleetInfo($deldate,$routename,$ordertype)
    {

        $driversondutyStops=  DB::connection('sqlsrv3')
            ->select("EXEC spLiveDriversAppInfo '".$deldate."','".$routename."','".$ordertype."'");

        return view('dims/individual_driver_deliveries_status')
            ->with('stops', $driversondutyStops);

    }
    public function ligisticsplan($dates)
    {
        $Date = (new \DateTime($dates))->format('Y-m-d');
        //$Date='2019-07-05';
        $livebulk = DB::connection('sqlsrv3')
            ->select("EXEC spLogisticsPlan '" . $Date . "'");

        $livePalnned = DB::connection('sqlsrv3')
            ->select("EXEC spLogisticsPlannedRoutes '" . $Date . "'");

        //dd($livebulk);
        return view('dims/logistics_plan')
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
            ->select("select cast(DeliveryDate as date ) as DeliveryDate,r.Route,ot.OrderType,strdrivername,mnykmdone,mnykmoutt,strSealNumber
,dtm,ass.DriverName AssitName,driv.DriverName,driv.DriverId,ass.DriverId as assId,tblTrucks.TruckId,TruckName,RegNo
 from tblDeliveryDateRouting (nolock) tdd
inner join tblRoutes(nolock) r
on r.Routeid = tdd.RouteId
inner join tblOrderTypes (nolock) ot
on ot.OrderTypeId = tdd.OrderTypeId
left outer join tblDrivers driv
on driv.DriverId = tdd.DriverId
left outer join tblDrivers ass
on ass.DriverId = tdd.AssistantId
left outer join tblTrucks
on tblTrucks.TruckId = tdd.TruckId
left outer join tblDriversAppTripHeader
on tblDriversAppTripHeader.strroutename = r.Route
and  tblDriversAppTripHeader.strordertypes = ot.OrderType
and  cast(dteDeliveryDate as date) = cast(tdd.DeliveryDate as date)
 where DeliveryDateRoutingID = $deldateRoutingid ");

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
    public function creditNoteReasonsJSonWithBook($dateFrom,$dateTo)
    {
        $creditNote = DB::connection('sqlsrv3')
            ->select("Exec spViewCreditRequestFromTheApp '".$dateFrom."','".$dateTo."'");
        return response()->json($creditNote);
    }
    public function driverreq_perrouteJson($routingid)
    {
        $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
            ->select("EXEC spDriversAppRequisitionPerRoute ".$routingid);
        return response()->json($gridcustomerjsonspecials);

    }
    public function ordermapvisualisation($route,$ordertype,$deldate){
        $getTypes=  DB::connection('sqlsrv3')
            ->select("select OrderTypeId,OrderType,1 p from tblOrdertypes (nolock) where OrderType = '$ordertype'  union all select OrderTypeId,OrderType,2 p from tblOrdertypes (nolock)");

        $getroutes=  DB::connection('sqlsrv3')
            ->select("select RouteId,Route, 1 p from tblRoutes (nolock)  where Route = '$route' union all select RouteId,Route, 2 p from tblRoutes (nolock)");

        return view('dims/deliveredordervisualization')
            ->with('ot', $ordertype)
            ->with('getTypes', $getTypes)
            ->with('getRoutes', $getroutes)
            ->with('defauldate',$deldate)
            ->with('route', $route);
    }
    public function ordervisualjson(Request $request)
    {
        $route =$request->get('rid');
        $ordertype =$request->get('oid');
        $deldate =$request->get('delivdate');
        $driversondutyStops=  DB::connection('sqlsrv3')
            ->select("EXEC spDriversAppCoordinatedStopsByInvoice '".$deldate."','".$route."','".$ordertype."'");
        return response()->json($driversondutyStops);
    }
   public function getDrivers()
   {

       $returnDrivers =  DB::connection('sqlsrv3')
           ->select("Select * From tblDrivers  where InActive = 0 and DriverName is not null");
       return response()->json($returnDrivers);
   }
   public function amalgamation(Request $request)
   {
       $date = $request->get('deldate');
       $gridcustomerjsonspecials =  DB::connection('sqlsrv3')
           ->select("EXEC spPlannedRoutesNoteInvoiced '".$date."'");
       return response()->json($gridcustomerjsonspecials);
   }
   public function combineroutes(Request $request)
   {
       $routenew = $request->get('routenew');
       $ordertypenew = $request->get('ordertypenew');
       $dateto = $request->get('dateto');
       $sequence = $request->get('sequence');
       $orderheaderxml = $this->toxml($sequence, "xml", array("result"));
       dd($sequence);


   }
    public function getTrucks()
    {

        $trucks = DB::connection('sqlsrv3')
            ->select("Select * From tblTrucks");
        echo json_encode($trucks);
    }
    function getDriverId($driverName)
    {

        $getDriverId =DB::connection('sqlsrv3')
        ->select("Select [DriverId] as driverId From tblDrivers Where DriverName = '$driverName' ");
        //$users = $getComponents->result();
        return $getDriverId[0]->driverId;
    }
    public function getSpecificRoute($routes)
    {
        $getComponents = DB::connection('sqlsrv3')
            ->select("Select [Route] as RouteName From tblRoutes Where Routeid = '$routes' ");

        return $getComponents[0]->RouteName;
    }

    function getTruckId($truckName)
    {

        $getComponents = DB::connection('sqlsrv3')
            ->select("Select [TruckId] as truckId From tblTrucks Where TruckName = '$truckName' ");

        return $getComponents[0]->truckId;

    }
    function getOrderTypeID($orderTypeName)
    {

        $getComponents =DB::connection('sqlsrv3')
            ->select("Select [OrderTypeId] as orderTypeIdT From tblOrderTypes Where OrderType = '$orderTypeName' ");

        return $getComponents[0]->orderTypeIdT;
    }
    public function getShortLoadedReport(){
        return view('dims/loadingreport');
    }
    public function getDriverBIReport(){
        return view('dims/driverbireport');
    }
    public function driverbireportget(Request $request){
        $date = $request->get('date');
        $businessreport=  DB::connection('sqlsrv3')
            ->select("EXEC spBusinessIntelligenceReportThomas ? ",array($date));
        return response()->json($businessreport);
    }
    public function jsonshortloadedreport(Request $request){
        $datefrom = $request->get('datefrom');
        $dateto = $request->get('dateto');//started at Hoxies
        $shorloadedJasper=  DB::connection('sqlsrv3')
            ->select("EXEC spCustomerLoadingReportPerUser '".$datefrom."','".$dateto."'");
        return response()->json($shorloadedJasper);
    }
    function resultOnForcePrint()
    {

        $invoiceNumber  = $this->input->post('invNo');
        $invoiceNumber = strtoupper($invoiceNumber);

        if (strlen($invoiceNumber) > 4)
        {
            //spReprintInvoiceWithoutCopyTax
            DB::connection('sqlsrv3')
                ->statement("EXEC spMarkOrdersAsBackOrdersOnDIMS ");
            echo "Invoice No :".$invoiceNumber." Will be sent to the printer in 30 secods if it is correct";

        }else{
            echo "INVALID INVOICE NUMBER";
        }
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
    public function printLoadingSheet($routingId)
    {


        DB::connection('sqlsrv3')
            ->statement("INSERT INTO tblPrintedDocuments([DocumentType],[DocId],[User])
						VALUES(7,$routingId,1)");
        echo "PLEASE CHECK YOUR PRINTER";

        /*$queryCustomers =  DB::connection('sqlsrv3')
            ->select("EXEC spSavePrintedTripSheets" $routingId);*/
    }
    public function deselectIsPressed()
    {
        DB::connection('sqlsrv3')->statement("insert into tblManagementConsol(ConsoleTypeId, Importance, dtm, Message)
        values(98765,1, GETDATE(), 'DESELECT WAS PRESSED')");
    }
    public function checkIfRouteFullyLoaded($routeId,$orderType,$deliveryDate)
    {
        $getComponents = DB::connection('sqlsrv3')
            ->select("select count(OrderId) as OrderId From tblOrders where Loaded = 0 and RouteId=$routeId and LateOrder=$orderType and DeliveryDate='$deliveryDate'");

        echo intval($getComponents[0]->OrderId);
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
    public function getData($orderDate,$orderType,$routeName,$driver,$assistant,$truckname,$assistanttwo,$userId)
    {

        $driver = str_replace('%20', ' ', $driver);
        $assistant = str_replace('%20', ' ', $assistant);
        $truckname= str_replace('%20', ' ', $truckname);
        $orderType= str_replace('%20', ' ', $orderType);
        $assistanttwo= str_replace('%20', ' ', $assistanttwo);


        $driver= str_replace('decryptforwardslash', '/', $driver);
        $assistant= str_replace('decryptforwardslash', '/', $assistant);
        $truckname= str_replace('decryptforwardslash', '/', $truckname);
        $orderType= str_replace('decryptforwardslash', '/', $orderType);
        $assistanttwo= str_replace('decryptforwardslash', '/', $assistanttwo);

        $drivId = $this->getDriverId($driver);
        $truckID = $this->getTruckId($truckname);
        $orderId = $this->getOrderTypeID($orderType);
        $assistantID = $this->getDriverId($assistant);
        $assistanttwoID = $this->getDriverId($assistanttwo);

        $returnResults =DB::connection('sqlsrv3')
            ->select("select count(tblOrders.OrderId) as OrderId From tblOrders inner Join tblOrderDetails on tblOrders.OrderId= tblOrderDetails.OrderId where tblOrders.Loaded = 0 and RouteId=$routeName and LateOrder=$orderId and DeliveryDate='$orderDate'");
       // $returnResults = $getComponents->result();
        $theCountOnNotLoadedOrders = intval($returnResults[0]->OrderId);

        /*if (intval($theCountOnNotLoadedOrders) > 0){
            echo "THERE ARE SOME OUTSTANDING ORDERS ON THIS ROUTE NOT LOADED";
        }else{*/
        //echo html_entity_decode($routeName);

        //echo $drivId."".$truckID."".$assistantID."".$orderId;
        $getComponents = DB::connection('sqlsrv3')
            ->select("EXEC spGetTruckControlSheetData '$orderDate','$orderType','$routeName'");
        //$getComponents = $this->db->query("EXEC spGetTruckControlSheetData '2016-12-06','Standard','South run'");
        //$getComponents = $this->db->query("SELECT login,password FROM public.res_users");
        $users = $getComponents;
        $results = array(
            "aaData"=>$users);
        $json =  json_encode($users);

        $html = '';
        $html .= '<script>
function myFunction() {
    window.print();
}
</script>';

        if(count( $users) > 0){   $DeliveryDateRoutingID = $users[0]->DeliveryDateRoutingID;}else{
            $DeliveryDateRoutingID=0;
        }

        //var_dump($DeliveryDateRoutingID);
        $html .= "<p style='text-align:center;'>"."<button onclick='myFunction()'>Print </button></p>";
        echo "<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>";

        $html .='' ;
        $html .='.......................................................................................................................................................' ;
        $html .='<p></p>' ;

        $html .='<table border="1"><tr>
    <td>Route Name :'.$this->getSpecificRoute($routeName).'</td>
    <td>TRUCK :'.$truckname.'</td>
  </tr>
  <tr >
	<td>Driver :'.$driver.'</td>
	<td>Assistant :'.$assistant.$theCountOnNotLoadedOrders.'</td>
	</tr>
	<tr >
	<td>'.$orderDate.'</td>
	<td>Routing ID : '.$DeliveryDateRoutingID.'</td>

	</tr>
	</table>';

        $html .=<<<EOD
		<table width="100%" cellspacing="0"  border="1" style="font-size: 12pt;">

		<tr ><th width="5%">NO</th><th width="10%">Del Sequ</th><th width="30%">Customer</th><th>Invoice</th><th>Amount</th><th>Terms</th><th>Previous Balance</th><th>NOTES</th></tr>
EOD;

        $counter = 1;
        $printSequence = 1;

        foreach($users as $key=>$value)
        {
            if(strlen($value->InvoiceNo) < 4)
            {
                $html .='<tr style="background:red;">';
            }else{
                $html .='<tr>';
            }

            $html .='<td >'.$printSequence.'</td>';
            $html .='<td >'.$value->DeliverySequence.'</td>';
            $html .='<td>'.$value->DeliveryName.'-'. $value->OrderId.'</td>';

            $html .='<td >'.$value->InvoiceNo."</td>";
            $html .='<td align="center">'.number_format((float)$value->AccessTotal, 2, ',', ' ').'</td>';
            $html .='<td>'.$value->strPaymentTerm.'</td>';
            $html .='<td align="center">'.number_format((float)$value->BalanceDue, 2, ',', ' ').'</td>';
            $html .='<td></td>';

            $html .="</tr>";
            if($counter ==1)

            {
                DB::connection('sqlsrv3')
                    ->statement("UPDATE tblDeliveryDateRouting
												 SET TruckId='$truckID',DriverId='$drivId', AssistantId='$assistantID',AssistantTwoId='$assistanttwoID'
												 WHERE DeliveryDate='$orderDate' And RouteId='$routeName' AND OrderTypeId = '$orderId'");
            }
            $counter++;
            $printSequence++;
        }
        $html .= '</table>';
        $html .='<div>No Cash.... No Delivery</div>';
        $html .='<div>Comment Or Credit Note Request Book No:</div>';
        $html .='<div>PLEASE SIGN FOR RECEIPT OF ENVOLOPES-STATEMENT</div>';
        $html .=<<<EOD
<table border="1">

  <tr style="1px solid black;">
    <td height="20">LOADER..........................</td>
    <td>DRIVER:..........................</td>
    <td>ASSISTANT:..........................</td>
  </tr>
  <tr style='1px solid black;'>
    <td height="20">Km Begin:..........................</td>
    <td>Km End:..........................</td>
    <td>Diesel:..........................</td>
  </tr>
  <tr style='1px solid black;'>
    <td height="20"></td>
    <td></td>
    <td>Oil:..........................</td>
  </tr>

</table>
EOD;

        $html .='
<table border="1";>

  <tr>
    <td height="20">Truck Clean.................................................</td>
    <td height="20">Truck Lights.............................................</td>
	<td height="20">Temp Setting...........................................</td>
  </tr>
  <tr>
	<td height="20">Damages...................................</td>
	<td>Spanner Jack..........................................</td>
	<td>Spare Tire..................................</td>
  </tr>

</table>';

        $reprint = $users[0]->Closed;
        $url = env('APP_LOADING_APPLINK');//$this->url();
     //   dd($url);
        if($users[0]->Closed == 1)
        {
            $html .= "<a href='/$url/printLoadingSheet/$DeliveryDateRoutingID' >Re-Print</a>";
        }else{



            $html .= "<a href='/$url/printLoadingSheet/$DeliveryDateRoutingID' >Print</a>";
        }



        echo $html;
        //}
    }
    function url(){
        if(isset($_SERVER['HTTPS'])){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
    }
    public function pickingslipsbydep(){
        $routes =  DB::connection('sqlsrv3')
            ->select("Select * from tblRoutes order by Route");

        $ordertypes =  DB::connection('sqlsrv3')
            ->select("Select * from tblOrderTypes order by OrderTypeid");

        $strDepartment =  DB::connection('sqlsrv3')
            ->select("select * from tblPickingDepartments order by strDepartment");
        return view('dims/pickingslipsbydep')
            ->with("routes",$routes)
            ->with("ordertype",$ordertypes)
            ->with("strDepartment",$strDepartment)
            ;
    }
    public function getPickingSlipbyDeptInfo(Request $request){
        //deliverydate
        $routeid = $request->get("routeid");
        $ordertypeid = $request->get("ordertypeid");
        $deliverydate =(new \DateTime($request->get('deliverydate')))->format('Y-m-d');
        $deptype = $request->get("deptype");
        $LogisticsInsertMapRoute = $request->get("LogisticsInsertMapRoute");
        $getlist =DB::connection('sqlsrv3')
            ->select('exec spGetListOfPickingSlips ?,?,?,?',
                array($routeid,$ordertypeid,$deliverydate,$deptype)
            );
        return response()->json($getlist);
    }public function printselectedCustomers(Request $request){
    $Orderid = $request->get("Orderid");
    $deptId = $request->get("deptId");
    $routeid = $request->get("routeid");
    $ordertypeid = $request->get("ordertypeid");
    $deliverydate =(new \DateTime($request->get('deliverydate')))->format('Y-m-d') ;
    $orderheaderxml = $this->toxml($Orderid, "xml", array("result"));

    $create =DB::connection('sqlsrv3')
        ->select('exec spCreatePickingSlips ?,?,?,?,?',
            array($orderheaderxml,$routeid,$ordertypeid,$deliverydate,$deptId)
        );
}
public function getRouteMassOnPlanner(Request $request)
{
    $dateFrom = $request->get("dateFrom");
    $dateTo = $request->get("dateTo");
    $valandmass =DB::connection('sqlsrv3')
        ->select('exec spGetRouteMassOnPlanner ?,?',
            array($dateFrom,$dateTo)
        );
    return response()->json($valandmass);
}

}
