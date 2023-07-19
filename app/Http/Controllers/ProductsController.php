<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ProductsController extends Controller
{
    public function gridEditViewProducts()
    {
        $getProducts= DB::connection('sqlsrv3')->select("Select * from viewMassProducts  order by PastelDescription");
        $getPickingTeams= DB::connection('sqlsrv3')->select("Select * from tblPickingTeams order by PickingTeam");
        $intBinId= DB::connection('sqlsrv3')->select("Select * from [tblBinNames] order by intBinId");

        return view('dims/grideditviewproducts')
            ->with('producsts',$getProducts)
            ->with('intBinId',$intBinId)
            ->with('PickingTeams',$getPickingTeams);
    }
    public function updategridproductsAndTeams(Request $request)
    {
        $griddetails = $request->get('griddetails');//


        foreach ($griddetails as $value) {
            $margin = $value['Margin'];
            $BulkUnit = $value['BulkUnit'];
            if (trim(strlen($value['Margin']) < 1))
            {
                $margin = 'NULL';
            }
            if (trim(strlen($value['BulkUnit']) < 1))
            {
                $BulkUnit = 'NULL';
            }
            /*  dd("EXEC spUpdateMassProduct '" .$value['team_']. "',".$value['id_'].",
                 ".$value['Mass'].",".$value['Weight'].",'".$BulkUnit."',".$value['MultiLine'].",'".$value['Bin']."',".$margin.",'".$value['Status']."',".$value['SoldByWeight']);*/

            $insertOrderDetails = DB::connection('sqlsrv3')
                ->statement("EXEC spUpdateMassProduct '" .$value['team_']. "',".$value['id_'].",
               ".$value['Mass'].",".$value['Weight'].",'".$BulkUnit."',".$value['MultiLine'].",'".$value['Bin']."',".$margin.",'".$value['Status']."',".$value['SoldByWeight']);
        }
    }
    public function extraProdInfoView($prodid,$code)
    {
        $GetProductExtrainfo= DB::connection('sqlsrv3')
            ->select("Select PickingTeam,PickingTeam as theRealPickingTeam,tblPickingTeams.PickingTeamId,Binnumber,ProductMargin from viewtblProducts 
inner join tblPickingTeams on tblPickingTeams.pickingTeamId =  viewtblProducts.pickingTeamId
where ProductId=$prodid");

        $getBins= DB::connection('sqlsrv3')
            ->select("Select * from viewBins");

        $teams = DB::connection('sqlsrv3')
            ->select("Select * from tblPickingTeams");
        return view('dims/instock_qty_warehouses')->with('prodid',$prodid)->with('code',$code)
            ->with('getBins',$getBins)
            ->with('productextrainfo',$GetProductExtrainfo)->with('teams',$teams);
    }
    public function crowdpromotion(Request $request)
    {
        $markitpublic  = $request->get('markitpublic');
        $prodid  = $request->get('prodid');
        $getPublicResponse= DB::connection('linxbriefcase')
            ->select("EXEC spCrowdPromotion ".$prodid.",".$markitpublic);
        return response()->json($getPublicResponse);
    }
    public function getproductextrainformation($productId)
    {
       // $productId = $request->get('productId');//
        $GetProductExtrainfo= DB::connection('sqlsrv3')
            ->select("EXEC spGetproductWarehouseinfo ".$productId);
        return response()->json($GetProductExtrainfo);
    }
    public function selectPricelists()
    {
        $pricelists = DB::connection('sqlsrv3')->select("Select * from fnSelectPriceLists() order by PriceList");
        return view('dims/pricelists')
            ->with('pricelist',$pricelists);

    }
    public function createpricelist()
    {
        $pricelists = DB::connection('sqlsrv3')->select("Select * from fnSelectPriceLists() order by PriceList");
        $pricelistsName = DB::connection('sqlsrv3')->select("SELECT top 100 percent PriceList FROM tblPriceLists where PriceList is not null  ORDER BY LEFT(PriceList,PATINDEX('%[^0-9]%',PriceList)-1)");
        $groups = DB::connection('sqlsrv3')->select("Select * from tblGroups order by GroupName");
        return view('dims/createpricelist')
            ->with('pricelist',$pricelists)
            ->with('pricelistnames',$pricelistsName)
            ->with('groups',$groups)
           ;

    }
    public function getListPriceListPrices($id,$PListUsed)
    {
        //spListPriceListPrices
        $spListPriceListPrices = DB::connection('sqlsrv3')
            ->select("EXEC spListPriceListPrices " .$id.",".$PListUsed);
        return response()->json($spListPriceListPrices);
    }
    public function getPriceListUsed(Request $request)
    {
        //spListPriceListPrices
        $id = $request->get('pricelistid');//
        $spListPriceListPrices = DB::connection('sqlsrv3')
            ->select("EXEC spListPriceListUsed " .$id);
        //dd($spListPriceListPrices);
        return response()->json($spListPriceListPrices);
    }
    public function getPriceListTemplate()
    {
        //spListPriceListPrices
        $spListPriceListPrices = DB::connection('sqlsrv3')
            ->select("EXEC spPriceListTemplate ");
        return response()->json($spListPriceListPrices);
    }
    public function createnewpricelist($newname,$pricelistcopyfrom,$groups,$gp,$effectivedate){
        $userId = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        //'test',-99,0,-99,2019-02-01,'Admin',5141)//
        $spListPriceListPrices = DB::connection('sqlsrv3')
            ->select("EXEC spCreatePriceList '" .$newname."',".$groups.",".$gp.",".$pricelistcopyfrom.",'".$effectivedate."','".$userName."',".$userId);
        return response()->json($spListPriceListPrices);
    }
    public function postupdatepricelistinfo(Request $request)
    {
        $arrayinfo = $request->get('value');//
        $pricelistid = $request->get('pricelistid');//
        $margin = $request->get('margin');
        $userId = Auth::user()->UserID;
        $userName = Auth::user()->UserName;

        $getRouteProducts =DB::connection('sqlsrv3')
            ->select('exec spXMLUpdatePriceList ?,?,?,?,?',
                array($this->toxml($arrayinfo, "xml", array("result")),$userId,$pricelistid,$userName,$margin)
            );

        return response()->json($getRouteProducts);
    }
    public function itemsOutOfStockBeforePicking(Request $request)
    {
        $dates = $request->get('deldate');
        $getRouteProducts =DB::connection('sqlsrv3')
            ->select('exec spNoStockItemBeforeLoading ?',
                array($dates)
            );
        return response()->json($getRouteProducts);
    }
    public function getViewItemsOutOfStock()
    {
        $deldate =  (new \DateTime())->format('Y-m-d');

        return view('dims/rptitemsoutofstockbeforeloading')
            ->with('date',$deldate);
    }
    public function savedatafromimport(Request $request)
    {

        $pricelisttype= $request->get('pricelisttype');
         $arrayinfo = $request->get('value');//
         $lenVal= $request->get('lenVal');//
        $newpriceist = $request->get('newprice');

        $effectivedate = $request->get('effectivedate');
        $existinglists = $request->get('existinglists');

        $pricelistused= $request->get('pricelistused');
        $transactioType = "NEW";
        if($pricelisttype =="overridepricelist")
        {
            $transactioType = "OVERRIDE";
        }
        if($pricelisttype =="extendpricelist")
        {
            $transactioType = "EXTEND";
        }
        if($pricelisttype =="extendpricelist")
        {
            $transactioType = "EXTEND";
        }

      // dd(count($arrayinfo[0])) ;

       /* $start ="";
        for($i=0 ; $i < count($arrayinfo[0]);$i++)
        {
            $start.="Col".$i."="." XTbl.value('(Col".$i.")','varchar(500)')\n";
        }*/


        $main = array();
        $k = 0;
        $inner = 0;
        foreach ($arrayinfo as $key => $item) {
           // $arr = array();

            for($i = 4;$i <count($item);$i++ )
            {
                $arr[$inner]['ProductId'] = array_values($item)[0];
                $arr[$inner]['PriceList']=array_keys($item)[$i] ;
                $arr[$inner]['Price'] = array_values($item)[$i];
                $inner++;
                //$main[] =$arr;
            }
            //$main[$k] =$arr;
            //$inner=0;
            $k++;
           // dd(array_values($item)[3]."----".array_keys($item)[3]);


          //  $arr[$item['id']][$key] = $item;
        }



        //$keys = str_replace( ' ', '', array_keys( $arrayinfo ) );
        //$results = array_combine( $keys, array_values( $arrayinfo ) );
     //  echo $start;
        //dd();
        /*foreach ($stripResults as $val)
        {
            $val->[Price List 1]
        }*/

    //var_dump($this->toxml($arr, "xml", array("result"))); dd();
       // dd($newpriceist."-".$effectivedate."-".$existinglists."-".$pricelisttype."----".$pricelistused."--".$transactioType);
       // $userId = Auth::user()->UserID;
        ///$userName = Auth::user()->UserName;
        //dd( $this->toxml($arrayinfo, "xml", array("result")),$userId,$newpriceist,$userName,$effectivedate,$transactioType,$existinglists,$pricelistused);
       $getRouteProducts =DB::connection('sqlsrv3')
            ->select('exec spXMLSaveImportPriceListBulkData ?',
                array($this->toxml($arr, "xml", array("result")))
            );

       return response()->json($getRouteProducts);
    }
    public function getPricelistNamesAndViewInBulk()
    {
        $pricelistsName = DB::connection('sqlsrv3')->select("Exec [spPriceListNamesInOrder]");
        return view('dims/view_bulkpricelist')->with('pricelist',$pricelistsName);
    }
    public function getBulkPriceLists()
    {
        $bulkPricecList = DB::connection('sqlsrv3')->select("Exec [spGetPriceListTemplate]");
        return response()->json($bulkPricecList);
    }
    public function importexcelpricelist()
    {
        $pricelists = DB::connection('sqlsrv3')->select("Select * from fnSelectPriceLists() order by PriceList");
        $pricelistsName = DB::connection('sqlsrv3')->select("Exec [spPriceListNamesInOrder]");
        return view('dims/import_excel_pricelist')->with('pricelist',$pricelists) ->with('pricelistnames',$pricelistsName);
    }
    public function deletePriceList(Request $request)
    {
            $pricelistID = $request->get('pricelistid');
        $getRouteProducts = DB::connection('sqlsrv3')
            ->select("EXEC spDeletePriceList'".$pricelistID);

    }
    public function listOfPricelistsToDelete()
    {
        $pricelists = DB::connection('sqlsrv3')->select("Select * from fnSelectPriceLists() order by PriceList");
        return view('dims/pricelists')
            ->with('deletepricelist',$pricelists);
    }
    public function viewproductbydate()
    {
        $products = DB::connection('sqlsrv3')->select("Select * from viewtblProducts");
        return view('dims/products_on_invoice')->with('products',$products);
    }
    public function productbydatejson($deldate1,$deldate2,$product)
    {
        $returnCustomerAndCreditLimitNotesUpdates= DB::connection('sqlsrv3')
            ->select("Exec spProductsByDateReports ?,?,?",
                array($deldate1,$deldate2,$product));
        return response()->json($returnCustomerAndCreditLimitNotesUpdates);
    }
    public function printbarcode(Request $request)
    {
        $productId = $request->get('productId');
        $locationId =  Auth::user()->LocationId;
        //dd($locationId);
        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spPrintBarcode ?,?",
                array($productId,$locationId));

        return response()->json($returnprinteddoc);
    }
    public function updateproductsummary(Request $request)
    {
        $productId = $request->get('productId');
        $bin = $request->get('bin');
        $teams = $request->get('teams');
        $prodMargin = $request->get('prodMargin');
        //$locationId =  Auth::user()->LocationId;
        //dd($locationId);
        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spUpdateProductInfo ?,?,?,?",
                array($productId,$bin,$teams,$prodMargin));

        return response()->json($returnprinteddoc);
    }
    public function bulkgridforlabels()
    {

        return view('dims/printlabelgrip');

    }
    public function bulkgridforlabelJson()
    {
        $getProducts= DB::connection('sqlsrv3')->select("Select * from viewMassProducts  order by PastelDescription");
        return response()->json($getProducts);

    }
    public function listProdutsToBePrintedJson()
    {
        $defaultlable =  Auth::user()->WindowsUserLogin;
        $returnprinteddoc= DB::connection('sqlsrv3')
            ->select("Exec spMobileProductListToPrint ?",
                array( $defaultlable));
        return response()->json($returnprinteddoc);

    }
    public function listProdutsToBePrinted()
    {
        return view('dims/listproductstobeloaded');

    }

    public function printbulklabels(Request $request)
    {
        $griddata = $request->get('griddetails');
        $locationId =  Auth::user()->LocationId;
        //dd($locationId);

        foreach ($griddata as $griddatum ) {
            $returnprinteddoc= DB::connection('sqlsrv3')
                ->select("Exec spPrintBarcode ?,?",
                    array($griddatum['id_'],$locationId));
        }


        return response()->json($returnprinteddoc);
    }
    public function printbulklabelsbyPricelist(Request $request)
    {
        $griddata = $request->get('griddetails');
        $locationId =  Auth::user()->LocationId;
        //dd($locationId);

        foreach ($griddata as $griddatum ) {
            //printed
            if($griddatum['printed'] != "1") {
                $returnprinteddoc = DB::connection('sqlsrv3')
                    ->select("Exec spPrintBarcode ?,?",
                        array($griddatum['id_'], $locationId));
            }
        }


        return response()->json($returnprinteddoc);
    }
    public function printAllBarcode(Request $request)
    {
        $griddata = $request->get('value');
        $locationId =  Auth::user()->LocationId;

        //dd($locationId);
        $getProducts= DB::connection('sqlsrv3')->select("Select top 10  * from viewtblProducts ");
        foreach ($getProducts as $griddatum ) {
            $returnprinteddoc= DB::connection('sqlsrv3')
                ->select("Exec spPrintBarcode ?,?",
                    array($griddatum->ProductId,$locationId));
        }


        return response()->json($returnprinteddoc);
    }
    public function sendstickerstoprinter(Request $request)
    {
        $griddata = $request->get('griddetails');
        $locationId =  Auth::user()->LocationId;

        //dd($locationId);

        foreach ($griddata as $griddatum ) {
            if($griddatum['howmany'] != "0") {
                $returnprinteddoc = DB::connection('sqlsrv3')
                    ->select("Exec spPrintProductSticker ?,?,?",
                        array($griddatum["id_"], $locationId, $griddatum["howmany"]));
            }
        }


        return response()->json($returnprinteddoc);
    }
    public function printPriceList()
    {
        $getPriceLists= DB::connection('sqlsrv3')->select("Select * from tblPriceLists  order by PriceList");
        return view('dims/printupdateprices')->with('pricelistdata',$getPriceLists);
    }
    public function PrintProductBarcodeStickers()
    {

        return view('dims/printstickers');
    }
    public function viewlabelstickerstoprint()
    {
        $getPriceLists= DB::connection('sqlsrv3')->select("Select PastelCode,ProductId,PastelDescription,BarCode,0 howmany from viewtblProducts  order by PastelDescription");
        return response()->json($getPriceLists);
    }
    public function productdevexpress()
    {
        $getPriceLists= DB::connection('sqlsrv3')->select("Select PastelCode,ProductId,PastelDescription,BarCode,Binnumber,theRealPickingTeam,QtyInStock,salesquantity,Available,Margin from viewtblProductsAndsalesQuantity  order by PastelDescription");
        return response()->json($getPriceLists);
    }
    public function getPickingTeams()
    {
        $getPickingTeams= DB::connection('sqlsrv3')->select("Select * from tblPickingTeams");
        return response()->json($getPickingTeams);
    }
    public function devExpressProductsgrid()
    {
        return view('dims/massproductgrid');
      //  $getPriceLists= DB::connection('sqlsrv3')->select("Select PastelCode,ProductId,PastelDescription,BarCode,0 howmany from viewtblProducts  order by PastelDescription");
    }
    public function listChangedProducts($dateFrom,$dateTo,$pricelistname)
    {

        //dd($locationId);
            $returnprinteddoc= DB::connection('sqlsrv3')
                ->select("Exec spListUpdatedPrices ?,?,?",
                    array($dateFrom,$dateTo,$pricelistname));



        return response()->json($returnprinteddoc);
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
