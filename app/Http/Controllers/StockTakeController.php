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
        
        $stocktakedata = $this->apiGetReferenceData([
            'reference'=>$reference
        ]);
        return view('dims.stockTakeConfirm.index')->with('stocktakedata',$stocktakedata);
    }


    public function assignStockTakeProductBinMappings($reference,$username){
        $assignMappingsData = $this->apiGetAssignMappingData([
            'reference'=>$reference,
            'username'=>$username
        ]);
        return view('dims.stockTakeAssignMappings.index')->with('assignMappingsData',$assignMappingsData);
    }

    public function viewStockTakeMappings($reference,$username){

        $viewMappingsData = $this->apiGetMappedData([
            'reference'=>$reference,
            'username'=>$username
        ]);
        return view('dims.stockTakeViewMappings.index')->with('viewMappings',$viewMappingsData);
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
