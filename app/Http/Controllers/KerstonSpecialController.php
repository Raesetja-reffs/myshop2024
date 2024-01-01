<?php

namespace App\Http\Controllers;
use App\Http\Controllers\SalesForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Cache;
use Illuminate\Support\Facades\Auth;
use Excel;
use App\Imports\SpecialsImport;
use App\Exports\SpecialsExport;


class KerstonSpecialController extends Controller
{
    public function export($contractId)
    {

       // return Excel::download(new SpecialsExport(), 'specials.xlsx');
        return (new SpecialsExport($contractId))->download('specials.xlsx');
    }
   public function dialogtoimportspecials($customerId,$contractIdfile,$datefromfile,$datetofile){
    return view ('dims/importfile')
    ->with('customerId',$customerId)
    ->with('contractid',$contractIdfile)
    ->with('datefrom',$datefromfile)
    ->with('dateto',$datetofile);
   }
    public function importexcel(Request $request){

        $this->validate($request, [
            'select_file'  => 'required|mimes:xls,xlsx'
           ]);
           $filefrompost = $request->file('select_file');

           $datefrom = $request->get('datefromfile');
           $dateto =$request->get('datetofile');
           $customerid =$request->get('customerIdfile');
           $contractid =  $request->get('contractIdfile');
           $sessionUserId = Auth::user()->UserID;
           //dd(  $customerid );


           $path = $request->file('select_file')->getRealPath();

           $data = Excel::import(new SpecialsImport, $filefrompost);
           //
           $convertBulk = DB::connection('sqlsrv3')
           ->statement('exec spInsertIntotblSpecialsImportIds ?,?',
               array($sessionUserId, $contractid)
           );
           echo "FILE IMPORTED, PLEASE CLOSE THE DIALOG";


           //return redirect('/andNewSpecialKF')->with('success', 'All good!');
}
public function createnewcustomercontract(Request $request){

    $date = (new \DateTime($request->get('dateFrom')))->format('Y-m-d');
    $dateTo = (new \DateTime($request->get('dateTo')))->format('Y-m-d');
    $Customerid = $request->get('customerId');
    $newcontract = DB::connection('sqlsrv3')
           ->select('exec spCreateNewCustomerContractId ?,?,?',
               array($Customerid, $date,$dateTo)
           );
           return response()->json($newcontract);

}
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function convertContractPriceBulk(Request $request){
        $contractId = $request->get('contractId');
        $pricelistid= $request->get('pricelist');
        $convertBulk = DB::connection('sqlsrv3')
            ->select('exec spConvertBulkPricelistCustSpec ?,?',
                array($contractId, $pricelistid)
            );

    }

    public function kerstonspecial()
    {
        //
        $sessionUserId = Auth::user()->UserID;
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )
            ->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')
            ->where('StatusId',1)

            ->orderBy('CustomerPastelCode','ASC')->get();

        return view('dims/kerstonspecials')
                ->with('customers',$queryCustomers);
    }
    public function customerByDateOrContractSpecKF(Request $request)
    {

        $contractId = $request->get('contractId');

        $GetCustomerSpecail = DB::connection('sqlsrv3')
            ->select('exec spCustomerSpecialFilter ?',
                array($contractId)
            );
        return response()->json($GetCustomerSpecail);
        //spCustomerSpecialFilter
//SpecialHeaderId
    }
    public function andNewSpecialKF()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available','PurchOrder')->orderBy('PastelDescription','ASC')->distinct()->get();

        return view('dims/addnewcustomerspecialkf/index')
                ->with('customers',$queryCustomers)->with('products',$queryProducts);
    }
    public function getCustomerAvgQty(Request $request){

        $customerid = $request ->get('customerID');
        $productcode = $request ->get('productCode');
        $getAvgQty = DB::connection('sqlsrv3')
        ->select('exec spGetAvgQtyProducts ?,?',
        array($customerid,$productcode));
        return response()->json($getAvgQty);
    }
    public function convertCurrentContractPricelist(Request $request){
        $contractid = $request ->get('contractid');
        $pricelistid = $request ->get('pricelistid');
         DB::connection('sqlsrv3')
        ->statement('exec spConvertContractPriceListid ?,?',
        array($contractid,$pricelistid));
    }
    public function getCurrentPricesProductsCustomerSpecialsKF (Request $request){
        $customerid= $request->get('customerID');
        $deliverydate= $request->get('deliveryDate');
        $returnfulldataload = DB::connection('sqlsrv3')
        ->select('exec spGetFullLoadForCustSpecials ?,?', array($customerid,$deliverydate)  );

     /*   $returnitemlist= DB::connection('sqlsrv3')
            ->select('exec spItemLooKupDevXtreme ');
        $outPut['specials'] = $returnfulldataload;
        $outPut['items'] = $returnitemlist;*/
        return response()->json($returnfulldataload);
    }
    public function spItemLooKupDevXtreme(){
        $returnitemlist= DB::connection('sqlsrv3')
            ->select('exec spItemLooKupDevXtreme ');
        return response()->json($returnitemlist);

    }
    public function XmlCreateCustomerSpecialsKFValid(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $customerId = $request->get('customerId');
        $contractid = $request->get('contractid');
        $orderDetails = $request->get('orderDetails');
        $date = (new \DateTime($request->get('contractDateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('contractDateTo')))->format('Y-m-d');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $orderDetailsxml = $orderDetails;

        $returnresults = DB::connection('sqlsrv3')
            ->select("EXEC spXMLCustomerSpecialsKFValidation '".$orderDetailsxml."',".$customerId.",'".$contractid."'");

        $outPut['result'] = $returnresults;
        return $outPut;

    }
    public function XmlCreateCustomerSpecials(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $customerId = $request->get('customerId');
        $contractId = $request->get('contractId');
        $orderDetails = $request->get('orderDetails');
        $date = (new \DateTime($request->get('contractDateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('contractDateTo')))->format('Y-m-d');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;

        $orderDetailsxml = $this->toxml($orderDetails, "xml", array("result"));

        $returnresults = DB::connection('sqlsrv3')
            ->select("EXEC spXMLCustomerSpecials '".$orderDetailsxml."',".$userid.",'".$userName."','".$date."','".$dateTo."',".$customerId.",".$contractId);
        $outPut['result'] = $returnresults[0]->Result;
        return $outPut;

    }
    public function XmlCreateCustomerSpecialsKF(Request $request)
    {
        $customerCode = $request->get('customerCode');
        $customerId = $request->get('customerId');
        $orderDetails = $request->get('orderDetails');
        $date = (new \DateTime($request->get('contractDateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('contractDateTo')))->format('Y-m-d');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;

        $orderDetailsxml = $orderDetails;
        $returnresults = DB::connection('sqlsrv3')
            ->select("EXEC spXMLCustomerSpecialsKF '".$orderDetailsxml."',".$userid.",'".$userName."','".$date."','".$dateTo."',".$customerId);
        $outPut['result'] = $returnresults[0]->Result;
        return $outPut;

    }
    public function getDuplicateProductsCS(Request $request)
    {
        $customerId = $request->get('customerId');
        $orderDetails = $request->get('orderDetails');
        $contractid= $request->get('contractid');

        $orderDetailsxml = $this->toxml($orderDetails, "xml", array("result"));

        $returnresults = DB::connection('sqlsrv3')
            ->select("EXEC spXMLCustomerSpecialGetDupes '".$orderDetailsxml."',".$customerId.",".$contractid);

        return view('dims/productduplicate')
        ->with('products',$returnresults);
    }
    public function postCurrentHistoryCustomerSpecialsKF(Request $request){
        $customerCode = $request->get('customercode');
        $customerid =$request->get('customerId');
        $contractid = $request->get('contractid');

       DB::connection('sqlsrv3')
        ->statement('exec spCustomerSpecialHistoryKF ?,?,?',
        array($customerCode,$customerid,$contractid));


    }
    public function copycontract(Request $request){

        $contructId = $request->get('contructId');
        $customerIdToCopyTo =$request->get('customerIdToCopyTo');
        $contractIdToCopyTo =$request->get('contractIdToCopyTo');
        $dateFrom =(new \DateTime($request->get('dateFrom')))->format('Y-m-d');
        $dateTo = (new \DateTime($request->get('dateTo')))->format('Y-m-d');
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        //dd($userName);
       $GetCustomerSpecail = DB::connection('sqlsrv3')
        ->select('exec spCopyCustomerSpecialFrom ?,?,?,?,?,?,?',
        array($contructId,$customerIdToCopyTo,$contractIdToCopyTo,$dateFrom,$dateTo,$userid,$userName));

        return response()->json($GetCustomerSpecail);

    }
    public function getCurrentContractCustomerSpecialsKF(Request $request){
        $contractid = $request->get('contractid');

        $GetCustomerSpecail = DB::connection('sqlsrv3')
        ->select('exec spCustomerSpecialContractKF ?',
        array($contractid));

        return response()->json($GetCustomerSpecail);

    }

    //below refers to 1st page
    public function getContractsPerCustomerID(Request $request){
        $customerid = $request->get('customerid');
        $getcontracts = DB::connection('sqlsrv3')
        ->select('exec spGetContractsPerCustomerId ?',
        array($customerid));

        return response()->json($getcontracts);
    }
    public function validatethecontractId(Request $request){
        $enteredcontract = $request->get('entercontracts');
        $getcontracts = DB::connection('sqlsrv3')
        ->select('exec spValidateContractID ?',
        array($enteredcontract));

        return response()->json($getcontracts);
    }
    public function getcontractDates(Request $request){
        $contractId = $request->get('contractId');
        $getcontracts = DB::connection('sqlsrv3')
        ->select('exec spGetDatesForTheSelectedContract ?',
        array($contractId));

        return response()->json($getcontracts);
    }
    public function deletecontractlines(Request $request){
        $contractid = $request->get('contractid');
        DB::connection('sqlsrv3')->table('tblCustomerSpecials')->where('SpecialHeaderId',$contractid)->delete();

    }
    public function deleteALLBasedContract(Request $request){
        $contractid = $request->get('contractid');
        DB::connection('sqlsrv3')->table('tblCustomerSpecials')->where('SpecialHeaderId',$contractid)->delete();
        DB::connection('sqlsrv3')->table('tblCustomerSpecialHeader')->where('SpecialHeaderId',$contractid)->delete();

    }
    public function searchSpecialKF(){
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode')->orderBy('CustomerPastelCode','ASC')->get();
        $queryProducts =DB::connection('sqlsrv3')->table("viewtblProducts" )->select('ProductId','PastelDescription','PastelCode')->orderBy('PastelCode','ASC')->get();

        return view('dims/searchcustomerspecialkf/index')
            ->with('customers',$queryCustomers)
            ->with('products',$queryProducts);
    }
    public function getCurrentSpecialsSearch(Request $request){
        $customers = $request->get('customers');
        $customers = implode(", ", $customers);
        $products = $request->get('products');
        $products = implode(", ", $products);

        $getSpecialsOnParams = DB::connection('sqlsrv3')
            ->select("EXEC spGetSpecialsFromSearchParams ?,? ",array($customers,$products));

        return response()->json($getSpecialsOnParams);
    }

    function getContractsPerCustomerIDWithDates(Request $request){
        $customerid = $request->get('customerid');
        $dateFrom =  $request->get('datefrom');
        $dateTo =  $request->get('dateto');
        $dateFrom = (new \DateTime($dateFrom))->format('Y-m-d');
        $dateTo = (new \DateTime($dateTo))->format('Y-m-d');


        $getcontracts = DB::connection('sqlsrv3')
        ->select('exec spGetContractsPerCustomerId ?,?,?',
        array($customerid,$dateFrom,$dateTo));


        return response()->json($getcontracts);
    }

    public static function toxml($arr, $root = "xml", $elements = Array())
    {
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }private static function getTabs($tabcount)
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
}
/*class KerstonSpecialExportController implements FromQuery{

}*/
