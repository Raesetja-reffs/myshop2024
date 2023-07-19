<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApisContoller extends Controller
{
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $data2 = $data['data'];
        $string = array();
        foreach($data2 as $value){
             $string[] = "'".$value['ID']."'";
        }
        $jsonString = implode(",",$string);
       echo response()->json($jsonString);

    }
    public function getOrderTypes()
    {
        $getOrderTypes =  DB::connection('sqlsrv3')
            ->select("select * from tblOrderTypes");
        return response()->json($getOrderTypes);
    }
    public function getRoutes()
    {
        $getOrderTypes =  DB::connection('sqlsrv3')
            ->select("select * from tblRoutes");
        return response()->json($getOrderTypes);
    }
}
