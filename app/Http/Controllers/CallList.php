<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 18/10/2017
 * Time: 10:58 AM
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class CallList extends Controller
{
    public function index()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        $getDeliveryDates = DB::connection('sqlsrv3')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();
        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();

        $marginType =  DB::connection('sqlsrv3')->table('tblCOMPANYREPORTS')->select('ReportType', 'Comment')->where('ReportName','marginCalculator')
            ->where('Function','1')
            ->get();


        switch ($marginType[0]->ReportType)
        {
            case 'marginType1':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->get();
                break;
            case 'marginType2':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->get();
                break;
            case 'marginType3':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->get();
                break;
            case 'marginType4':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->get();
                break;
            case 'marginType5':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax',DB::raw('-9999999 AS Cost'),'QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->get();
                break;

        }

        $trueFalse =  DB::connection('sqlsrv3')->table('tblCOMPANYREPORTS')->select('ReportType', 'ReportName')->where('ReportName','True')
            ->orwhere('ReportName','False')
            ->get();
        $getLastInserted= DB::connection('sqlsrv3')
            ->select("Select * from viewGetLastInsertedOrderIdAndDeliveryDate");

        return view('dims/call-list/index')->with('products',$queryProducts)
            ->with('trueOrFalse',$trueFalse)
            ->with('LastInserted',$getLastInserted)
            ->with('customers',$queryCustomers)
            ->with('margin',$marginType[0]->ReportType)
            ->with('orderTypes',$deliverTypes)
            ->with('delivDates',$getDeliveryDates)
            ->with('routesNames',$getRoutes);

    }
    public function insertCallistFilters(Request $request)
    {
        $userName = $request->get('UserName');
        $intUserId = $request->get('intUserId');
        $routeName = $request->get('routeName');
        $routeId = $request->get('routeId');
        $sessionUserId = Auth::user()->UserID;
        //Insert into Filter table this is used by the callist on the order form
        DB::connection('sqlsrv3')->table('tblCallistFilters')->insert(
            ['strUserName' => $userName, 'intUserId' => $intUserId,
                'strRouteName' => $routeName,'intRouteId'=>$routeId,
                'intSessionUserId'=>$sessionUserId
            ]);

    }
    public function callLogger(Request $request)
    {
        //$path = scandir('C:\Rubish\PDF');
        $dates = $request->get('dates');
        $path = scandir('\\\\192.168.1.185\TMNData\\'.$dates);
        $dir = '\\\\192.168.1.185\TMNData\\'.$dates;
        $result = array();
        $mainArray = array();
      /*  foreach ($path as $item){
            if ($item != '..' && $item != '.' ){
                array_push($sub_dirs, $item);
            }
        }*/
       // $this->dirToArray($dir);
       // dd($this->dirToArray($dir));


       $lists = array("one","two","three","four","five","six");
       $extension =1 ;
        foreach ($this->dirToArray($dir) as $val)
        {

            for ($i = 0; $i < count($val) ;$i++)
            {
              //  dd($val[$i]);
                $countExplode = array();
                $string = $val[$i]."-".$extension;
                $countExplode = explode("-", $string);

                if (count($countExplode) >=6 ){$mainArray[] = explode("-", $string);}



            }
            $extension++;

           // dd($mainArray[0]);
            /*if (strlen($val) > 0) {
                //$parts=pathinfo('somefile.jpg');
                //echo $parts['extension'];
                $mainArray[] = explode(",", $val);
            }*/

        }

       /* $param = "calllog.txt";
        $reportCall =  DB::connection('sqlsrv3')->table('tblCOMPANYREPORTS')->select('ReportName')
            ->where('ReportType','CallLog')
            ->first();
        $resultName = $reportCall->ReportName;
        $file = fopen($resultName.$param, "r");
        $members = array();
        $results = array();

        while (!feof($file)) {
            $members[] = fgets($file);
        }

        fclose($file);

        foreach ($members as $val)
        {
          if (strlen($val) > 0) {
              //$parts=pathinfo('somefile.jpg');
              //echo $parts['extension'];k
              $results[] = explode(",", $val);
          }
        }
      // ;*/
       //dd($mainArray);

        $newArray = array();
        $fRes = array();
        for ($i =0 ; $i < count($mainArray);$i++ ){

            for($p=0;$p < count($lists) ; $p++){

               //echo  $mainArray[$i][0];
                $newArray[$i][$lists[$p]] = $mainArray[$i][$p];

            }
        }

        //dd($newArray);
        $answer = $this->toxml($newArray, "xml", array("result"));
        //dd($answer);
        $getResult = DB::connection('callLogger')
            ->select("EXEC spXmlcallLogger '" . $answer . "'");

        return response()->json($getResult);
        /*return view('dims/callLoger')
            ->with('results', $getResult);*/

    }
    function getViewCallLoger()
    {
        $GroupId = Auth::user()->GroupId;
        $things = (new SalesForm())->getThings($GroupId,'Allow Call Logger');
        return view('dims/callLoger')->with('things',$things);
    }

    function luck($datef,$ext,$file){
        //dd($ext.'-'.$file);
        $filename = $datef.'\\'. $ext.'\\'.$file;
        $file = '\\\\192.168.1.185\TMNData\\'.$filename;

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
      //  dd($file);
    }


    function dirToArray($dir) {

        $result = array();

        $cdir = scandir($dir);
        $outVal = 0;
        foreach ($cdir as $key => $value)
        {


            if (!in_array($value,array(".","..")))
            {

                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                {
                    //echo $value;

                    $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                }
                else
                {
                    //dd($value);

                    $result[] = $value;
                }
            }
        }

       // dd($outVal);
        //dd($result[]);
        return $result;
    }
    public function getPhoneBook()
    {
        $queryCustomers =DB::connection('sqlsrv3')->table("viewtblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute','mnyCustomerGp','ID','Warehouse')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        return view('dims/call-list/phonebook')->with('customers',$queryCustomers);
    }
    public function customerphonebookcontacts(Request $request)
    {
        $customerId = $request->get('customerId');

        $queryProducts= DB::connection('sqlsrv3')
            ->select("Exec spCustomerPhoneBook ".$customerId);
        return response()->json($queryProducts);
    }
    public function savephonebook(Request $request)
    {
        $customerId = $request->get('customerid');
        $contacts = $request->get('contacts');
        //dd($contacts);
        $answer = $this->toxml($contacts, "xml", array("result"));
        $queryProducts= DB::connection('sqlsrv3')
            ->statement("Exec spSavePhoneBook ".$customerId.",'".$answer."'");
        return response()->json($queryProducts);
    }
    public function removePhoneBookContact(Request $request)
    {
        $removeSpecial = $request->get('removeSpecial');
        DB::connection('sqlsrv3')->table('tblPhoneBook')
            ->where('intCustomerContactID',$removeSpecial)
            ->delete();
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
