<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 28/06/2017
 * Time: 12:18 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\GetThings;

class ArtificialCrud extends Controller
{
    public function updateCart(Request $request)
    {

        $editval = $request->input('editval');
        $id = $request->input('id');


        DB::connection('sqlsrv4')->table('tblOrderDetails')
            ->where('intOrderDetailId', $id)
            ->update(['fltQty' =>$editval]);
    }
    public function updatereordering(Request $request)
    {

        $editval = $request->input('editval');
        $id = $request->input('id');
        $mainId = $request->input('mainId');

        DB::connection('linxbriefcase')->table('OrderLines')
            ->where('ID', $mainId)
            ->where('strPartNumber', $id)
            ->update(['Quantity' =>$editval]);
    }
    public function deleteCartItems(Request $request)
    {
        $id = $request->input('intOrderId');
       // dd( $id );
        DB::connection('sqlsrv4')->table('tblOrderDetails')->where('intOrderId', '=', $id)->delete();

        $items = DB::connection('sqlsrv4')->select("SELECT tblOrderDetails.intOrderDetailId, tblOrderDetails.intOrderId, tblOrderDetails.strProductCode, tblOrderDetails.fltQty, tblOrderDetails.fltPrice, tblOrderDetails.fltPriceInc, tblOrderDetails.fltVat, 
                                tblOrderDetails.created_at, tblOrderDetails.updated_at, tblProducts.productCode, tblOrders.orderID, tblOrders.dteOrderDate, tblOrders.dteDeliveryDate, tblProducts.imageName, tblProducts.description, 
                                tblProducts.title
                                FROM tblOrderDetails INNER JOIN
                                tblProducts ON tblOrderDetails.strProductCode = tblProducts.productCode INNER JOIN
                                tblOrders ON tblOrderDetails.intOrderId = tblOrders.orderID
                                WHERE (tblOrders.orderID =  $id)");
        $total=0;
        foreach($items as $item){

            $total+=$item->fltPrice;
        }
        return view('cart',['items'=>$items,'total'=>$total]);
    }
    public function invoiceDetails($invoiceNo,$proceed)
    {
        $dimsCustName = "ADM003";
        //$dimsCustName = Auth::user()->strCustName;

        $invoicesLines =DB::connection('sqlsrv3')->select("SELECT tblOrders.OrderId, tblOrders.CustomerId, tblOrders.OrderDate, tblOrders.DeliveryDate, tblOrders.OrderNo, tblOrders.Invoiced, 
                                                            tblOrders.InvoiceNo, tblOrderDetails.Qty,tblOrderDetails.OrderDetailId, 
                                                            tblOrderDetails.Price, tblProducts.PastelDescription,tblProducts.PastelCode, tblCustomers.CustomerPastelCode, tblCustomers.StoreName
                                                            FROM tblOrders INNER JOIN
                                                                 tblOrderDetails ON tblOrders.OrderId = tblOrderDetails.OrderId INNER JOIN
                                                                 tblProducts ON tblOrderDetails.ProductId = tblProducts.ProductId INNER JOIN
                                                                 tblCustomers ON tblOrders.CustomerId = tblCustomers.CustomerId
                                                            WHERE        (tblOrders.Invoiced = 1) AND (tblCustomers.CustomerPastelCode = '$dimsCustName') AND (tblOrders.InvoiceNo = '$invoiceNo')
                                                            ORDER BY tblOrders.DeliveryDate DESC");
        //dd($invoicesLines);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $t=time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t."-".$randomString.$dimsCustName.$invoiceNo;

        return view('invoicedetails',['items'=>$invoicesLines,'invoiceNumber'=>$invoiceNo,'token'=>$ID]);


    }
    public function reorderBasedOnSelectedInvoice(Request $request)
    {
        $mergedArrat = array();
        $arrayProdCode = $request->input('prolang');
        $arrayQty = $request->input('gty');
        for($i=0;$i<count($arrayProdCode);$i++){
            $mergedArrat[$i]['productCode'] = $arrayProdCode[$i];
            $product = (new GetThings())->getProduts($arrayProdCode[$i],'PastelDescription');
            $mergedArrat[$i]['productDescription'] =$product;
            $mergedArrat[$i]['gty'] =$arrayQty[$i];
        }

       // dd($mergedArrat);

      /*  $dimsCustName = "ADM003";
        //$dimsCustName = Auth::user()->strCustName;
        $invoiceNo = $request->input('referencedinvoice');
        $reference = $request->input('reference');
        $ID = $request->input('token__id');
        $deliverydate = (new \DateTime($request->input('deliverydate')))->format('Y-m-d');

        $invoicesLines =DB::connection('sqlsrv3')->select("SELECT tblOrders.OrderId, tblOrders.CustomerId, tblOrders.OrderDate, tblOrders.DeliveryDate, tblOrders.OrderNo, tblOrders.Invoiced, 
                                                            tblOrders.InvoiceNo, tblOrderDetails.Qty,tblOrderDetails.OrderDetailId, 
                                                            tblOrderDetails.Price, tblProducts.PastelDescription,tblProducts.PastelCode, tblCustomers.CustomerPastelCode, tblCustomers.StoreName
                                                            FROM tblOrders INNER JOIN
                                                                 tblOrderDetails ON tblOrders.OrderId = tblOrderDetails.OrderId INNER JOIN
                                                                 tblProducts ON tblOrderDetails.ProductId = tblProducts.ProductId INNER JOIN
                                                                 tblCustomers ON tblOrders.CustomerId = tblCustomers.CustomerId
                                                            WHERE        (tblOrders.Invoiced = 1) AND (tblCustomers.CustomerPastelCode = '$dimsCustName') AND (tblOrders.InvoiceNo = '$invoiceNo')
                                                            ORDER BY tblOrders.DeliveryDate DESC");


        $orderDate = (new \DateTime())->format('Y-m-d');
            //dd($orderDate);
        //Price changes frequent so i must call function to check the price depending on the customer price list and vat
        foreach($invoicesLines as $values)
        {
            $checkDetailID =DB::connection('linxbriefcase')->select("SELECT [ID],[strPartNumber]
                                                                      FROM [LinxBriefcase].[dbo].[OrderLines]
                                                                      where id='$ID'");
            //if ($checkDetailID[0]->ID != $ID && $checkDetailID[0]->strPartNumber != $values->PastelCode) {
                DB::connection('linxbriefcase')->table('OrderLines')->insert(
                    ['ID' => $ID,
                        'strPartNumber' => $values->PastelCode,
                        'Quantity' => $values->Qty,
                        'Price' => $values->Price,
                        'Vat' => 14,
                        'Authorised' => 1
                    ]);
           // }
        }
       // if ($checkDetailID[0]->ID != $ID ) {
            DB::connection('linxbriefcase')->table('OrderHeaders')->insert(
                ['ID' => $ID,
                    'OrderDate' => $orderDate,
                    'DeliveryDate' => $deliverydate,
                    'OrderNumber' => $reference,
                    'CustomerCode' => $dimsCustName,
                    'Notes' => "",
                    'DeliveryAddressID' => 0
                ]);
      //  }
        $reordering =DB::connection('linxbriefcase')->select("SELECT OrderLines.ID, OrderLines.strPartNumber, OrderLines.Quantity, OrderLines.Price, OrderLines.Vat, OrderLines.Authorised, OrderLines.DIMSOrderDetailID, OrderHeaders.DeliveryDate, OrderHeaders.OrderDate, 
                                                        OrderHeaders.OrderNumber, OrderHeaders.CustomerCode, Products.strDesc
                                                        FROM  OrderLines INNER JOIN
                                                                                 OrderHeaders ON OrderLines.ID = OrderHeaders.ID INNER JOIN
                                                                                 Products ON OrderLines.strPartNumber = Products.strPartNumber
                                                        WHERE (OrderHeaders.ID = '$ID')");*/
        return view('continuereordering')->with('items',$mergedArrat);
    }
    public function deleteReorderingItems(Request $request)
    {

    }

}