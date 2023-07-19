<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use IlluminateHttpRequest;

class ApisController extends Controller
{
    public function sendFCMMessage()
    {
        $curl = curl_init();
        $token_ids = array('fk5U59AZp9M:APA91bHrhAYRmKOBQxJQFJRKwiRJ6jDhg-clNUvPpjtc-MD_w-LKlzYNngRzcDV6QW39n3WJ20qhUx1UeDai-kvVp_pdhbsre2dLhjt_VwvPM3eQitd2NZgj39N4MZVm5MPWG-F9LhpC', 'dclOKUwfV-E:APA91bFHkCXMntfJsCY7ATEM3X60629b_AFYq656EsPqa3BZeLz4khKmp6gGf-ZUogaJ8QInXefJi6bvlsbfSnpL3HVVsj_8VdBlF6SC9-9PABWQiTyVNpX__n4LGZZlGsHcXmG_NagW');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"data\":{\"title\":\"Hey there\",\"content\":\"Check Out This Awesome Game!\",\"body\":\"THis is the test\"},\"to\":$token_ids}",
            CURLOPT_HTTPHEADER => array(
                "authorization: key=AAAAtwbPrMM:APA91bHbiX3eUqjunfcjYBKi4Zk8Ip6dPtA7fXEU72_-xgI04cSnlLdLUL5tayZGrwiawfTzbr0I1vwvHF7kgOc8DLI8365dO5anh6e89h2kadV7s1baSyvXjdpGU7Q4ACwQHKndeUg7",
                "cache-control: no-cache",
                "content-type: application/json"

            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }


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
