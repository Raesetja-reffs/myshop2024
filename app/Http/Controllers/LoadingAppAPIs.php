<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 29/09/2017
 * Time: 04:35 PM
 */

namespace App\Http\Controllers;

use App\Notifications\TaskCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Traits\LoadingAppAPIsTrait;

class LoadingAppAPIs extends Controller
{
    use LoadingAppAPIsTrait;

    public function sendMessages(Request $request /*$ID,$Type,$Instructions*/)
    {
        $Instructions = $request->get('Instructions');
        $Type = $request->get('Type');
        $ID = $request->get('ID');
        $SplitI = explode("|", $Instructions);
        //dd($SplitI);
        $Date = (new \DateTime())->format('Y-m-d H:m:s');
        $url = "https://hooks.slack.com/services/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";
        //nonicname.slack.com
        switch ($Type) {
            case "UNLOCK":
                $OID = $SplitI[0];
                $UserID = $SplitI[1];
                break;
            case "LOCK":
                $OID = $SplitI[0];
                $UserID = $SplitI[1];
                break;
            case "UNLOADED":
                $OID = $SplitI[0];
                $ODID = $SplitI[1];
                $UserID = $SplitI[2];

                $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                $UserName = $getUserID[0]->UserName;

                $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId')->where('OrderDetailId', $ODID)->get(1);
                DB::connection('sqlsrv3')->update("UPDATE tblOrders SET Loaded = 0 WHERE OrderID = $OID");
                $ProductId = $sqlProducts[0]->ProductId;
                DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	                              VALUES ('8888','1','$Date','$UserName','User $UserID   UNLOADED OrderDetail $ODID',$UserID ,0,0,$OID,$ProductId,$OID,0)");
                break;
            case "LOADED":
                $OID = $SplitI[0];
                $ODID = $SplitI[1];
                $UserID = $SplitI[2];
                //98574785|5176770|33|1|1000|2

                $checkFirst = DB::connection('sqlsrv3')->table('tblOrderDetails')->where('OrderID',$OID)->where('Loaded',0)->get();

                if (count($checkFirst) < 1) {

                        DB::connection('sqlsrv3')->update("UPDATE tblOrders SET Loaded = 1 WHERE OrderID = $OID");
                }

                $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId')->where('OrderDetailId', $ODID)->get(1);
                $ProductId = $sqlProducts[0]->ProductId;

                $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                $UserName = $getUserID[0]->UserName;

                DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	                VALUES ('8888','1','$Date','$UserName','User $UserID  LOADED OrderDetail $ODID',$UserID ,0,0,$OID,$ProductId,$OID,0)");

                break;
            case "PRINT":
                $OID = $SplitI[0];
                $UserID = $SplitI[1];

                //UPDATE tblOrders SET Loaded = true WHERE OrderID = " & OID
                DB::connection('sqlsrv3')->update("UPDATE tblOrders SET Loaded = 1 WHERE OrderID = $OID");
                $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('PrinterPathInvoice')->where('UserID', $UserID)->get(1);
                $PrinterPathInvoice = $getUserID[0]->PrinterPathInvoice;

                DB::connection('sqlsrv3')->insert("INSERT INTO tblPrintedDocuments ( DocumentType, DocID, [User], PrinterPath )
                                                        VALUES (1 ,$OID,$UserID, '$PrinterPathInvoice')");
                break;
            case "UPDATE":
                $OID = $SplitI[0];
                $ODID = $SplitI[1];
                $UserID = $SplitI[2];
                $loaded = $SplitI[3];
                $Qty = $SplitI[4];
                $Count = $SplitI[5];
                //98574785|5176770|33|1|1000|2

                $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                $UserName = $getUserID[0]->UserName;

                $sqlProducts = DB::connection('sqlsrv3')->table('viewtblOrderDetails')->select('ProductId', 'Qty','PastelDescription','PastelCode')->where('OrderDetailId', $ODID)->get(1);
                $ProductId = $sqlProducts[0]->ProductId;
                $OriginQty = $sqlProducts[0]->Qty;
                $prodName = $sqlProducts[0]->PastelDescription;
                $prodCode = $sqlProducts[0]->PastelCode;

              /*  if (round($OriginQty,3) != round($Qty,3))
                {
                    try{
                        $client = new Client();
                        $request = $client->post($url,['body' =>json_encode(
                            [
                                'text' =>$UserName .' changed Quantity from '.$OriginQty.' to '.$Qty.'\nFor '.$OID.' on '.$prodName.' ['.$prodCode.']'
                            ]
                        )]);
                    }catch (Exception $e)
                    {
                        exit();
                    }
                }*/


                DB::connection('sqlsrv3')->update("UPDATE tblOrderDetails SET Qty = ROUND($Qty, 3) ,Loaded = $loaded  WHERE OrderDetailId = $ODID");
                DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	VALUES ('8888','1','$Date','$UserName','User $UserID  changed Quantity from $OriginQty to $Qty',$UserID ,$OriginQty,$Qty,$OID,$ProductId,$OID,0)");

                break;
            case "COMMENT":
                $OID = $SplitI[0];
                $ODID = $SplitI[1];
                $UserID = $SplitI[2];
                $OldComment = $SplitI[3];
                $Input = $SplitI[4];

                $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                $UserName = $getUserID[0]->UserName;
                $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId')->where('OrderDetailId', $ODID)->get(1);
                $ProductId = $sqlProducts[0]->ProductId;
                $Date = (new \DateTime())->format('Y-m-d H:m:s');

                DB::connection('sqlsrv3')->update("UPDATE tblOrderDetails SET Comment = '$Input' WHERE OrderDetailId = $ODID");

                DB::connection('sqlsrv3')
                    ->table('tblManagementConsol')
                    ->insert(['ConsoleTypeId'=>'8888','Importance'=>'1','dtm'=>$Date,'LoggedBy'=>$UserName,'Message'=>'User '. $UserID.'   changed Message from '. $OldComment.' to '. $Input
                ,'UserId'=>$UserID,'OldQty'=>0,'NewQty'=>0,'OrderId'=>$OID,'productid'=>$ProductId,'DocNumber'=>$OID,'Reviewed'=>0]);

                break;
            case "RED":
                $UserID = $SplitI[0];
                break;
        }

        echo $ID;
    }

    public function sendMessageJson(Request $request)
    {
        $myArray = $request->get('MyArray');

        $data2 = json_decode($myArray);
        $string = array();
        $test = '';

        foreach ($data2 as $value) {
            $Instructions = $value->Instruction;//$request->get('Instructions');
            $Type = $value->Type;
            $ID = $value->ID;
            $SplitI = explode("|", $Instructions);

            $Date = (new \DateTime())->format('Y-m-d H:m:s');

            switch ($Type) {
                case "UNLOCK":
                    $OID = $SplitI[0];
                    $UserID = $SplitI[1];
                    break;
                case "LOCK":
                    $OID = $SplitI[0];
                    $UserID = $SplitI[1];
                    break;
                case "UNLOADED":
                    $OID = $SplitI[0];
                    $ODID = $SplitI[1];
                    $UserID = $SplitI[2];

                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                    $UserName = $getUserID[0]->UserName;

                    $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId')->where('OrderDetailId', $ODID)->get(1);
                    DB::connection('sqlsrv3')->update("UPDATE tblOrders SET Loaded = 0 WHERE OrderID = $OID");
                    $ProductId = $sqlProducts[0]->ProductId;
                    DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	                              VALUES ('8888','1','$Date','$UserName','User $UserID   UNLOADED OrderDetail $ODID',$UserID ,0,0,$OID,$ProductId,$OID,0)");
                    break;
                case "LOADED":
                    $OID = $SplitI[0];
                    $ODID = $SplitI[1];
                    $UserID = $SplitI[2];
                    //98574785|5176770|33|1|1000|2

                    $checkFirst = DB::connection('sqlsrv3')->table('tblOrderDetails')->where('OrderID', $OID)->where('Loaded', 0)->get();

                    if (count($checkFirst) < 1) {

                        DB::connection('sqlsrv3')->update("UPDATE tblOrders SET Loaded = 1 WHERE OrderID = $OID");
                    }

                    $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId')->where('OrderDetailId', $ODID)->get(1);
                    $ProductId = $sqlProducts[0]->ProductId;

                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                    $UserName = $getUserID[0]->UserName;

                    DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	                VALUES ('8888','1','$Date','$UserName','User $UserID  LOADED OrderDetail $ODID',$UserID ,0,0,$OID,$ProductId,$OID,0)");

                    break;
                case "PRINT":
                    $OID = $SplitI[0];
                    $UserID = $SplitI[1];

                    //UPDATE tblOrders SET Loaded = true WHERE OrderID = " & OID
                    DB::connection('sqlsrv3')->update("UPDATE tblOrders SET Loaded = 1 WHERE OrderID = $OID");
                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('PrinterPathInvoice')->where('UserID', $UserID)->get(1);
                    $PrinterPathInvoice = $getUserID[0]->PrinterPathInvoice;

                    DB::connection('sqlsrv3')->insert("INSERT INTO tblPrintedDocuments ( DocumentType, DocID, [User], PrinterPath )
                                                        VALUES (1 ,$OID,$UserID, '$PrinterPathInvoice')");
                    break;
                case "UPDATE":
                    $OID = $SplitI[0];
                    $ODID = $SplitI[1];
                    $UserID = $SplitI[2];
                    $loaded = $SplitI[3];
                    $Qty = $SplitI[4];
                    $Count = $SplitI[5];
                    //98574785|5176770|33|1|1000|2

                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                    $UserName = $getUserID[0]->UserName;

                    $sqlProducts = DB::connection('sqlsrv3')->table('viewtblOrderDetails')->select('ProductId', 'Qty', 'PastelDescription', 'PastelCode')->where('OrderDetailId', $ODID)->get(1);
                    $ProductId = $sqlProducts[0]->ProductId;
                    $OriginQty = $sqlProducts[0]->Qty;


                    DB::connection('sqlsrv3')->update("UPDATE tblOrderDetails SET Qty = ROUND($Qty, 3) ,Loaded = $loaded  WHERE OrderDetailId = $ODID");
                    DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	VALUES ('8888','1','$Date','$UserName','User $UserID  changed Quantity from $OriginQty to $Qty',$UserID ,$OriginQty,$Qty,$OID,$ProductId,$OID,0)");

                    break;
                case "COMMENT":
                    $OID = $SplitI[0];
                    $ODID = $SplitI[1];
                    $UserID = $SplitI[2];
                    $OldComment = $SplitI[3];
                    $Input = $SplitI[4];

                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                    $UserName = $getUserID[0]->UserName;
                    $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId')->where('OrderDetailId', $ODID)->get(1);
                    $ProductId = $sqlProducts[0]->ProductId;
                    $Date = (new \DateTime())->format('Y-m-d H:m:s');

                    DB::connection('sqlsrv3')->update("UPDATE tblOrderDetails SET Comment = '$Input' WHERE OrderDetailId = $ODID");

                    DB::connection('sqlsrv3')
                        ->table('tblManagementConsol')
                        ->insert(['ConsoleTypeId' => '8888', 'Importance' => '1', 'dtm' => $Date, 'LoggedBy' => $UserName, 'Message' => 'User ' . $UserID . '   changed Message from ' . $OldComment . ' to ' . $Input
                            , 'UserId' => $UserID, 'OldQty' => 0, 'NewQty' => 0, 'OrderId' => $OID, 'productid' => $ProductId, 'DocNumber' => $OID, 'Reviewed' => 0]);

                    break;
                case "RED":
                    $UserID = $SplitI[0];
                    break;
            }
            $string[] = "'".$ID."'";
        }
        $jsonString = implode(",",$string);
        echo  json_encode($jsonString);
    }

    public function sendMessagePicking(Request $request)
    {
        $myArray = $request->get('MyArray');

        $data2 = json_decode($myArray);
        $string = array();
        $test = '';

        foreach ($data2 as $value) {
            $Instructions = $value->Instruction;//$request->get('Instructions');
            $Type = $value->Type;
            $ID = $value->ID;
            $SplitI = explode("|", $Instructions);

            $Date = (new \DateTime())->format('Y-m-d H:m:s');

            switch ($Type) {
                case "UNLOCK":
                    $OID = $SplitI[0];
                    $UserID = $SplitI[1];
                    break;
                case "LOCK":
                    $OID = $SplitI[0];
                    $UserID = $SplitI[1];
                    break;
                case "UNLOADED":
                    $OID = $SplitI[0];
                    $ODID = $SplitI[1];
                    $UserID = $SplitI[2];

                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                    $UserName = $getUserID[0]->UserName;

                    $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId')->where('OrderDetailId', $ODID)->get(1);
                    DB::connection('sqlsrv3')->update("UPDATE tblOrders SET blnPicked = 0 WHERE OrderID = $OID");
                    $ProductId = $sqlProducts[0]->ProductId;
                    DB::connection('sqlsrv3')->update("UPDATE tblOrderDetails SET fltQtyPicked = (SELECT Qty FROM tblOrderDetails WHERE OrderDetailId = $ODID) WHERE OrderDetailId = $ODID ");

                    DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	                              VALUES ('8888','1','$Date','$UserName','User $UserID   UNPICKED OrderDetail $ODID',$UserID ,0,0,$OID,$ProductId,$OID,0)");
                    break;
                case "LOADED":
                    $OID = $SplitI[0];
                    $ODID = $SplitI[1];
                    $UserID = $SplitI[2];
                    //98574785|5176770|33|1|1000|2

                    $checkFirst = DB::connection('sqlsrv3')->table('tblOrderDetails')->where('OrderID', $OID)->where('Loaded', 0)->get();

                    if (count($checkFirst) < 1) {

                        DB::connection('sqlsrv3')->update("UPDATE tblOrders SET blnPicked = 1 WHERE OrderID = $OID");
                    }

                    $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId','fltQtyPicked')->where('OrderDetailId', $ODID)->get(1);
                    $ProductId = $sqlProducts[0]->ProductId;

                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                    $UserName = $getUserID[0]->UserName;
                    DB::connection('sqlsrv3')->update("UPDATE tblOrderDetails SET fltQtyPicked = (SELECT Qty FROM tblOrderDetails WHERE OrderDetailId = $ODID) WHERE OrderDetailId = $ODID ");

                    DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	                VALUES ('8888','1','$Date','$UserName','User $UserID  PICKED OrderDetail $ODID',$UserID ,0,0,$OID,$ProductId,$OID,0)");

                    break;
                case "PRINT":
                    $OID = $SplitI[0];
                    $UserID = $SplitI[1];

                    //UPDATE tblOrders SET Loaded = true WHERE OrderID = " & OID
                    DB::connection('sqlsrv3')->update("UPDATE tblOrders SET blnPicked = 1 WHERE OrderID = $OID");
                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('PrinterPathInvoice')->where('UserID', $UserID)->get(1);
                    $PrinterPathInvoice = $getUserID[0]->PrinterPathInvoice;

                    DB::connection('sqlsrv3')->insert("INSERT INTO tblPrintedDocuments ( DocumentType, DocID, [User], PrinterPath )
                                                        VALUES (1 ,$OID,$UserID, '$PrinterPathInvoice')");
                    break;
                case "UPDATE":
                    $OID = $SplitI[0];
                    $ODID = $SplitI[1];
                    $UserID = $SplitI[2];
                    $loaded = $SplitI[3];
                    $Qty = $SplitI[4];
                    $Count = $SplitI[5];
                    //98574785|5176770|33|1|1000|2

                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                    $UserName = $getUserID[0]->UserName;

                    $sqlProducts = DB::connection('sqlsrv3')->table('viewtblOrderDetails')->select('ProductId', 'Qty', 'PastelDescription', 'PastelCode')->where('OrderDetailId', $ODID)->get(1);
                    $ProductId = $sqlProducts[0]->ProductId;
                    $OriginQty = $sqlProducts[0]->Qty;


                    DB::connection('sqlsrv3')->update("UPDATE tblOrderDetails SET fltQtyPicked = ROUND($Qty, 3) ,blnPicked = $loaded  WHERE OrderDetailId = $ODID");
                    DB::connection('sqlsrv3')->insert("Insert into tblManagementConsol (ConsoleTypeId,Importance,dtm,LoggedBy,Message,UserId,OldQty,NewQty,OrderId,productid,DocNumber,Reviewed)
	VALUES ('8888','1','$Date','$UserName','User $UserID  changed Quantity from $OriginQty to $Qty',$UserID ,$OriginQty,$Qty,$OID,$ProductId,$OID,0)");

                    break;
                case "COMMENT":
                    $OID = $SplitI[0];
                    $ODID = $SplitI[1];
                    $UserID = $SplitI[2];
                    $OldComment = $SplitI[3];
                    $Input = $SplitI[4];

                    $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserName')->where('UserID', $UserID)->get(1);
                    $UserName = $getUserID[0]->UserName;
                    $sqlProducts = DB::connection('sqlsrv3')->table('tblOrderDetails')->select('ProductId')->where('OrderDetailId', $ODID)->get(1);
                    $ProductId = $sqlProducts[0]->ProductId;
                    $Date = (new \DateTime())->format('Y-m-d H:m:s');

                    DB::connection('sqlsrv3')->update("UPDATE tblOrderDetails SET Comment = '$Input' WHERE OrderDetailId = $ODID");

                    DB::connection('sqlsrv3')
                        ->table('tblManagementConsol')
                        ->insert(['ConsoleTypeId' => '8888', 'Importance' => '1', 'dtm' => $Date, 'LoggedBy' => $UserName, 'Message' => 'User ' . $UserID . '   changed Message from ' . $OldComment . ' to ' . $Input
                            , 'UserId' => $UserID, 'OldQty' => 0, 'NewQty' => 0, 'OrderId' => $OID, 'productid' => $ProductId, 'DocNumber' => $OID, 'Reviewed' => 0]);

                    break;
                case "RED":
                    $UserID = $SplitI[0];
                    break;
            }
            $string[] = "'".$ID."'";
        }
        $jsonString = implode(",",$string);
        echo  json_encode($jsonString);
    }
    public function batchPrinting(Request $request)
    {
        $myArray = $request->get('MyArray');

        $data2 = json_decode($myArray);
        $string = array();

        $UserID = $request->get('userID');

        $getUserID = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('PrinterPathInvoice')->where('UserID', $UserID)->get(1);
        $PrinterPathInvoice = $getUserID[0]->PrinterPathInvoice;

        foreach ($data2 as $value)
        {
            $checkFirst = DB::connection('sqlsrv3')->table('tblOrders')->where('OrderID',$value->OrderID)->where('Loaded',1)->get();

            if (count($checkFirst) > 0) {


                DB::connection('sqlsrv3')->update("UPDATE tblOrders SET Loaded = 1 WHERE OrderID = $value->OrderID");
                DB::connection('sqlsrv3')->insert("INSERT INTO tblPrintedDocuments ( DocumentType, DocID, [User], PrinterPath )
                                                        VALUES (1,$value->OrderID,$UserID, '$PrinterPathInvoice')");
            }
            //this is for loaded products
            $checkFirst2 = DB::connection('sqlsrv3')->select("Exec spPickingLoadingVariances ".$value->OrderID);
            if (count($checkFirst2) > 0 )
            {
                DB::connection('sqlsrv3')->insert("INSERT INTO tblPrintedDocuments ( DocumentType, DocID, [User], PrinterPath )
                                                        VALUES (4001,$value->OrderID,$UserID, '$PrinterPathInvoice')");
            }

            $string[] = "'".$value->OrderID."'";
        }
        $jsonString = implode(",",$string);

        echo  json_encode($jsonString);

    }

    public function slack()
    {
        $url = "https://hooks.slack.com/services/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";
        try{


        $client = new Client();

        $request = $client->post($url,['body' =>json_encode(
            [
                'text' => 'World'
            ]
        )]);
        }catch (Exception $e)
        {
            exit();
        }
dd($request) ;
        //$response = $request->send();
       // dd($response);



       // dd($response);*/
        //$slack = new Slack();

        //  $user = Auth::user();
        //  $user->notify(new TaskCompleted('messages jjj')) ;
        //$usersList = $this->SlackUser->lists();


    }
    public function stockApi(Request $request)
    {
       /* $productCode = $request->get('ItemCode');
        $products = DB::connection('sqlsrv3')->table('tblProducts')->where('PastelCode', $productCode)->first();
        $brandId = $products->BrandId;
        //BrandId
        $client = new Client();
        $res = $client->get('http://localhost:8888/stock.php',['query' =>  [ 'ItemCode' => $productCode,'OrderDetailID'=>0,'BrandId'=>$brandId]]);
       return $res->getBody();*/
        $productCode = $request->get('ItemCode');
        if (config('app.IS_API_BASED')) {
            $available = $this->apistockApi([
                'productCode' => $productCode
            ]);
        } else {
            $products = DB::connection('sqlsrv3')->table('viewtblProductsAndsalesQuantity')->where('PastelCode', $productCode)->get();
            $available = 0;
            if (count($products) < 1)
            {
                $available = 0;
            }else{
                $available = $products[0]->Available;
            }
        }

        return $available;
    }

    /*
     * $productCode = $request->get('ItemCode');
        $client = new Client();
        $res = $client->get('http://192.168.0.254:8880/getposition/stock.php',['query' =>  [ 'ItemCode' => $productCode,'OrderDetailID'=>0]]);
       return $res->getBody();
     */

}
