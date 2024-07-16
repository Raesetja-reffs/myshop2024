<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Traits\StockTakeControllerTrait;

class StockTakeController extends Controller
{
    use StockTakeControllerTrait;

    public function stocktake (){
        $users = $this->apiGetStockTakeUsers();
        return view('dims.stockTake.index')->with('users',$users);
    }

    
    public function getStockTakes(Request $request){

        $dateFrom= $request->get('dateFrom');
        $dateTo = $request->get('dateTo');


        if (config('app.IS_API_BASED')) {
            $response = $this->apiGetStockTakes([
                'dateFrom'  => $dateFrom,
                'dateTo'  => $dateTo,
            ]);
            return response($response);
        } else {
            $response = DB::connection('sqlsrv3')->select("EXEC sp_API_R_GetStockTakes");
            return response()->json($response);
        }

        
    }

    public function createStockTake(Request $request){

        $reference= $request->get('reference');
        $blues= $request->get('blues');
        $reds= $request->get('reds');
        $managers= $request->get('managers');


        if (config('app.IS_API_BASED')) {
            $this->apiCreateStockTake([
                'reference'  => $reference,
                'blues'  => $blues,
                'reds'  => $reds,
                'managers'  => $managers,
            ]);

            $this->apiUpdateStockTakeUsers([
                'blues'  => $blues,
                'reds'  => $reds,
                'managers'  => $managers,
            ]);
            return response(1);
        } else {
            $response = DB::connection('sqlsrv3')->select("EXEC sp_API_C_CreateStockTake ?,?,?,?",array());


            return response()->json(1);
        }

        
    }

    public function confirmStocktakeFor($reference)
    {
        if (config('app.IS_API_BASED')) {
            $stocktakedata = $this->apiGetReferenceData([
                'reference'=>$reference
            ]);
            }else{


                $stocktakedata  =DB::connection('sqlsrv3')->select("Exec sp_API_R_GetStockTakeDataOnName ?",array($reference));
                  
            }
        return view('dims.stockTakeConfirm.index')->with('stocktakedata',$stocktakedata);
    }


    public function assignStockTakeProductBinMappings($reference,$username){

        if (config('app.IS_API_BASED')) {
        $productData = $this->apiGetProductData();
        $binData = $this->apiGetBinData();
        }else{
            $productData  =DB::connection('sqlsrv3')->select("Exec sp_API_R_GetProductData");
            $binData =DB::connection('sqlsrv3')->select("Exec [sp_API_R_GetBinData]");
                }
        return view('dims.stockTakeAssigning.index')->with('productData',$productData)->with('binData',$binData)
        ->with('stocktakename',$reference)->with('username',$username);
    }

    public function submitMappedStockData(Request $request){
        $stocktakename= $request->get('stocktakename');
        $username= $request->get('username');
        $bins= $request->get('bins');
        $warehouses= $request->get('warehouses');
        $stocktaketype= $request->get('stocktaketype');
        $itemlist= $request->get('itemlist');
        if (config('app.IS_API_BASED')) {
                $this->apiSubmitMappedStockData([
                    'stocktakename'=>$stocktakename,
                    'username'=>$username,
                    'bins'=>$bins,
                    'warehouses'=>$warehouses,
                    'stocktaketype'=>$stocktaketype,
                    'itemstringxml'=>$itemlist,
                ]);
            }else{
                
            DB::connection('sqlsrv3')->statement("EXEC sp_API_C_SubmitMappedStockData ?,?,?,?,?,?",array($stocktakename,$username,$bins,$warehouses,$stocktaketype,$itemlist));
            }
            
    }

    public function getProductDataFromBins(Request $request){
        $bins= $request->get('bins');
        
        if (config('app.IS_API_BASED')) {
              $productdata=  $this->apiGetProductDataFromBins([
                    'bins'=>$bins,
                ]);
            }else{
                
                $productdata=  DB::connection('sqlsrv3')->select("EXEC sp_API_R_GetProductDataFromBins ?",array($bins));
            }
            
            return response()->json($productdata);
    }



    public function viewStockTakeMappings($reference,$username){

        if (config('app.IS_API_BASED')) {
        $viewMappingsData = $this->apiGetMappedData([
            'reference'=>$reference,
            'username'=>$username
        ]);
        }else{
                
        $viewMappingsData =DB::connection('sqlsrv3')->select("EXEC sp_API_R_GetMappedStocktakeData ?,?",array($reference,$username));
            }
        return view('dims.stockTakeViewAssigned.index')->with('viewMappings',$viewMappingsData);
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
