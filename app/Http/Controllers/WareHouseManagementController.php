<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Traits\WareHouseManagementControllerTrait;

class WareHouseManagementController extends Controller
{
    use WareHouseManagementControllerTrait;

    public function productscats(){
        $getProducts= DB::connection('barcoding')->select("Select * from viewWhsmainCats ORDER BY group1");
        return view('dims/whstmaincats')
            ->with('products',$getProducts);
    }
    public function getProductsnames($cat)
    {
        $getProducts= DB::connection('barcoding')->select("Select * from viewBarcodeCollecter
left outer join tblTempItemsAndBarcodes
on tblTempItemsAndBarcodes.strPastelCode = viewBarcodeCollecter.Code
where [GROUP 1] = '$cat' and strItemBarcode is null
ORDER BY [GROUP 2],[GROUP 3] ,Description_1 ");

        return view('dims/barcodecollector')
            ->with('products',$getProducts)->with('cat',$cat);
    }
    public function getwarehouseinventorygrid()
    {
        return view('stockmover/warehouseinventorygrid');

    }
    public function qtyadjustmentsstagingimoveit()
    {
        $this->authorize('isAllowCompanyPermission', ['App\Models\CompanyPermission', 'isallowqtyadjstage']);
        return view('wims/stagingimoveitadjustments');

    }
    public function qtyadjustmentspicking()
    {
        $this->authorize('isAllowCompanyPermission', ['App\Models\CompanyPermission', 'isallowqtyadjpicking']);
        return view('wims/qtyadjustonpicking');

    }
    public function jsonadjustmentstagingtoimoveit($date1,$date2)
    {
        $driver = DB::connection('sqlsrv3')
            ->select("EXEC spItemQtyChangesonStagingtoreturns '".$date1."','".$date2."'");
       // dd($driver);
        return response()->json($driver);
    }
    public function jsonadjustmentspicking($date1,$date2)
    {
        $driver = DB::connection('sqlsrv3')
            ->select("EXEC spItemQtyChangesonpicking '".$date1."','".$date2."'");
       // dd($driver);
        return response()->json($driver);
    }
    public function reprintingInvoicesPage(){
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();

        return view('dims/reprintinginvoicespage')
        ->with('orderTypes',$deliverTypes)
        ->with('routes',$getRoutes);
    }
    public function reprintPrintedInvoicesParameters(Request $request){
        $deldatefr = (new \DateTime($request->get('deldatestart')))->format('Y-m-d');

        $deldateto = (new \DateTime($request->get('deldateend')))->format('Y-m-d');
        $routeid = $request->get("routeId");
        $ordertypeid = $request->get("orderTypeId");

        $userid = Auth::user()->UserID;
        DB::connection('sqlsrv3')
                    ->statement('exec spInsertBatchDocumentsPrintingParams ?,?,?,?,?',
                        array($deldatefr, $deldateto,$routeid,$ordertypeid,$userid));

    }
    public function jsonWarehouseGrid(){
        $getProducts= DB::connection('barcoding')->select("Select * from viewWareHouseStockDataGrid order by productName");
        return response()->json($getProducts);
    }
    public function recordbarcode($productCode)
    {
        $getProducts= DB::connection('barcoding')->select("Select * from viewBarcodeCollecter  where Code='$productCode' ");

        return view('dims/barcodeform')
            ->with('products',$getProducts);
    }
    public function savebarcode(Request $request)
    {
        $itemCode = $request->get("Code");
        $barcode = $request->get("barcode");
        $strLocationName = $request->get("location");
        $expdate = $request->get("expdate");
        $cat = $request->get("cat");

        DB::connection('barcoding')->table('tblTempItemsAndBarcodes')->insert(
            ['strPastelCode' => $itemCode, 'strItemBarcode' => $barcode,'strLocationName'=> $strLocationName,'dteExpiryDate'=>$expdate]
        );

        return redirect("getProductsnames/$cat");
    }

    public function massProducts()
    {
        if (config('app.IS_API_BASED')) {
            $pickingTeams = $this->apiMassProducts();
        } else {
            $pickingTeams = DB::connection('sqlsrv3')
                ->select('Select * from tblPickingTeams');
        }

        return view('dims/mass_product')->with('pickingTeams', $pickingTeams);
    }

    public function getProductgriddata(){
        $getRouteProducts =DB::connection('sqlsrv3')
            ->select('Select * from viewMassProducts');
        return response()->json($getRouteProducts);
    }
    public function postProductInfo(Request $request){

        $productid = $request->get("ProductID");
        $pickingteamid = $request->get("PickingTeamId");
        $strBulkUnit = $request->get("strBulkUnit");
        $UnitWeight = $request->get("UnitWeight");
        $SoldByWeight = $request->get("SoldByWeight");
        $ProductMargin = $request->get("ProductMargin");

        //dd('exec spUpdatedProductInfoDataGrid '.$productid.",".$pickingteamid);
        DB::connection('sqlsrv3')
            ->statement('exec spUpdatedProductInfoDataGrid ?,?,?,?,?,?',
                array($productid, $pickingteamid,$strBulkUnit,$UnitWeight,$SoldByWeight,$ProductMargin));
    }
    public function stockmover(){

        return view('stockmover/stockmoverlanding');
    }
    public function scanshelffrom(){

        return view('stockmover/shelffrom');
    }
    public function goscanproductfrom(Request $request){
        $shelffrom = $request->get("shelffrom");
        //dd($shelffrom);
        return view('stockmover/productfrom')->with('shelffrom',$shelffrom);
    }

    public function goscanshelfto(Request $request){
        $shelffrom = $request->get("shelffrom");
        $productfrom = $request->get("productfrom");
        $Qty = $request->get("Qty");
        return view('stockmover/shelfto')->with('shelffrom',$shelffrom)->with('productfrom',$productfrom)->with('Qty',$Qty);

    }

    public function goscanproductto(Request $request){
        $shelffrom = $request->get("shelffrom");
        $productfrom = $request->get("productfrom");
        $Qty = $request->get("Qty");
        $shelfto = $request->get("shelfto");

        return view('stockmover/productto')->with('shelffrom',$shelffrom)->with('productfrom',$productfrom)->with('Qty',$Qty)->with('shelfto',$shelfto);
    }
    public function gofinish(Request $request){
        $shelffrom = $request->get("shelffrom");
        $productfrom = $request->get("productfrom");
        $Qty = $request->get("Qty");
        $shelfto = $request->get("shelfto");
        $productto= $request->get("productto");
        $confirmqty = $request->get("confirmqty");
        $expiry = $request->get("expiry");


        return view('stockmover/finishedstockmoving')->with('shelffrom',$shelffrom)
            ->with('productfrom',$productfrom)
            ->with('productto',$productto)
            ->with('Qty',$Qty)
            ->with('confirmqty',$confirmqty)
            ->with('expiry',$expiry)
            ->with('shelfto',$shelfto);
    }
    public function savestockmover(Request $request){

        $shelffrom = $request->get("shelffrom");
        $productfrom = $request->get("productfrom");
        $Qty = $request->get("Qty");
        $shelfto = $request->get("shelfto");
        $productto= $request->get("productto");
        $confirmqty = $request->get("confirmqty");

        DB::connection('barcoding')->table('tblInventoryAndBinMover')->insert(
            ['strShelfFrom' => $shelffrom, 'strBarcodeFrom' => $productfrom,'strShelTo'=> $shelfto,'strBarcodeTo'=>$productto
                ,'mnyQtyFrom'=> $Qty,'mnyQtyTo'=>$confirmqty]
        );
    }
    public function stocksheetforstocktake(){
        return view('stockmover/stocktakesheet');
    }
    public function stocksheetforstocktakejson(){
        $getRouteProducts =DB::connection('sqlsrv3')
            ->select('Select * from viewStockTakeSheet');
        return response()->json($getRouteProducts);
    }
    public function stocksheetforstocktakexml(Request $request){

        $orderlines = $request->get('lines');
        //dd($orderlines);
        $orderlinesrxml = $this->toxml($orderlines, "xml", array("result"));
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $stocktake = $request->get('stocktake');

        $getResult = DB::connection('sqlsrv4')
            ->select("EXEC spXMLMakeStockTake '" . $orderlinesrxml . "'," . $userid . ",'" . $userName . "','" . $stocktake . "'");

        return response()->json($getResult);
    }

    private static function getTabs($tabcount)
    {
        $tabs = '';
        for($i = 0; $i < $tabcount; $i++)
        {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = Array(), $tabcount = 0)
    {
        $result = '';
        $tabs = self::getTabs($tabcount);
        foreach($arr as $key => $val)
        {
            $element = isset($elements[0]) ? $elements[0] : $key;
            $result .= $tabs;
            $result .= "<" . $element . ">";
            if(!is_array($val))
                $result .= $val;
            else
            {
                $result .= "\r\n";
                $result .= self::asxml($val, array_slice($elements, 1, true), $tabcount+1);
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

}
