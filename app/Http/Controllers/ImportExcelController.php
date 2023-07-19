<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use Illuminate\Support\Facades\Auth;

class ImportExcelController extends Controller
{
    function index()
{

    $pricelists = \Illuminate\Support\Facades\DB::connection('sqlsrv3')
        ->select("select * from tblPriceLists"); //WHERE ID = ''

    return view('dims/import_excel')->with('pricelist',$pricelists);
}

    function import(Request $request)
    {
        $this->validate($request, [
            'select_file'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('select_file')->getRealPath();

        $data = Excel::load($path)->get();


        if($data->count() > 0)
        {
            foreach($data->toArray() as $key => $value)
            {
              //  dd($value);
                //dd($value['pastelcode']);
                if($value['pastelcode'] !=null){
                    $insert_data[] = array(
                        "pastelcode"  => $value['pastelcode'],
                        'pricelisetone'   => $value['13'],
                        'pricelisttwo'   => $value['14'],
                        'pricelistthree'    => $value['15'],
                        'pricelistfour'  => $value['16']
                    );
                }


            }

            $orderDetailsxml = $this->toxml($insert_data, "xml", array("result"));

            $userId = Auth::user()->UserID;
            $userName = Auth::user()->UserName;

            $salesreportinfo = \Illuminate\Support\Facades\DB::connection('sqlsrv4')
                ->select('exec spXMLBulkPriceListInsert ?,?,?',
                    array($orderDetailsxml, $userId, $userName)
                );

        }
        return back()->with('success', 'Excel Data Imported successfully.');
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
