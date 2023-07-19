<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Cart;
use App\CartItem;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $cart =DB::connection('sqlsrv4')->select("Select top 1 * from [Shop].[dbo].[tblOrders] where [strCustName]= '".Auth::user()->strCustName."'");

        //$cart = Cart::where('intUserID',Auth::user()->id)->first();
        if(!$cart){
            $cart =  new Cart();
            $cart->strCustName=Auth::user()->strCustName;
            $cart->save();
        }
       // dd($cart);
        $orderId = $cart[0]->orderID;
        $productCode = $request->input('id');
        $duplicates = DB::connection('sqlsrv4')->select("SELECT Count(strProductCode) as howmany FROM
                            (
                                SELECT tblOrderDetails.strProductCode
                                FROM tblOrderDetails INNER JOIN
                                tblProducts ON tblOrderDetails.strProductCode = tblProducts.productCode INNER JOIN
                                tblOrders ON tblOrderDetails.intOrderId = tblOrders.orderID
                                WHERE (tblOrders.orderID = $orderId ) AND (tblOrderDetails.strProductCode = '$productCode')
                            ) as z");


        if (intval($duplicates[0]->howmany) > 0) {
            $items = DB::connection('sqlsrv4')->select("SELECT        tblOrderDetails.intOrderDetailId, tblOrderDetails.intOrderId, tblOrderDetails.strProductCode, tblOrderDetails.fltQty, tblOrderDetails.fltPrice, tblOrderDetails.fltPriceInc, tblOrderDetails.fltVat, 
                         tblOrderDetails.created_at, tblOrderDetails.updated_at, tblProducts.productCode, tblOrders.orderID, tblOrders.dteOrderDate, tblOrders.dteDeliveryDate, tblProducts.imageName, tblProducts.description, 
                         tblProducts.title, tblOrderDetails.fltQty * tblOrderDetails.fltPrice AS lineTot
FROM            tblOrderDetails INNER JOIN
                         tblProducts ON tblOrderDetails.strProductCode = tblProducts.productCode INNER JOIN
                         tblOrders ON tblOrderDetails.intOrderId = tblOrders.orderID
                                WHERE (tblOrders.orderID =  $orderId)");
            $total=0;
            foreach($items as $item){

                $total+=$item->fltPrice;
            }
            return view('cart',['items'=>$items,'total'=>$total])
                ->withSuccessMessage('Item is already in your cart!');
        }
        $cartItem  = new Cartitem();
        $cartItem->strProductCode=$request->input('id');
        $cartItem->intOrderId= $cart[0]->orderID;
        $cartItem->fltPrice=$request->input('price');
        $cartItem->fltQty=$request->input('qty');
        //$cartItem->fltQty=1;
        $cartItem->save();

        $items = DB::connection('sqlsrv4')->select("SELECT        tblOrderDetails.intOrderDetailId, tblOrderDetails.intOrderId, tblOrderDetails.strProductCode, tblOrderDetails.fltQty, tblOrderDetails.fltPrice, tblOrderDetails.fltPriceInc, tblOrderDetails.fltVat, 
                         tblOrderDetails.created_at, tblOrderDetails.updated_at, tblProducts.productCode, tblOrders.orderID, tblOrders.dteOrderDate, tblOrders.dteDeliveryDate, tblProducts.imageName, tblProducts.description, 
                         tblProducts.title, tblOrderDetails.fltQty * tblOrderDetails.fltPrice AS lineTot
FROM            tblOrderDetails INNER JOIN
                         tblProducts ON tblOrderDetails.strProductCode = tblProducts.productCode INNER JOIN
                         tblOrders ON tblOrderDetails.intOrderId = tblOrders.orderID
WHERE        (tblOrders.orderID =  $orderId)");
        $total=0;
        foreach($items as $item){

            $total+=$item->fltPrice;
        }
        return view('cart',['items'=>$items,'total'=>$total]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        /*$cart = Cart::where('intUserID',Auth::user()->id)->first();

        if(!$cart){
            $cart =  new Cart();
            $cart->intUserID=Auth::user()->id;
            $cart->save();
        }

        $items = $cart->cartItems;
        dd($items);
        $total=0;
        foreach($items as $item){
            $total+=$item->product->price;
        }*/

        //return view('cart.view',['items'=>$items,'total'=>$total]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $orderSQL= DB::connection('sqlsrv4')->select("SELECT top 1 intOrderId FROM tblOrderDetails WHERE intOrderDetailId=$id");
        $orderId = $orderSQL[0]->intOrderId;
        DB::connection('sqlsrv4')->table('tblOrderDetails')->where('intOrderId', $orderId)->where('intOrderDetailId', $id)->delete();
       // dd($orderId);
        $items = DB::connection('sqlsrv4')->select("SELECT        tblOrderDetails.intOrderDetailId, tblOrderDetails.intOrderId, tblOrderDetails.strProductCode, tblOrderDetails.fltQty, tblOrderDetails.fltPrice, tblOrderDetails.fltPriceInc, tblOrderDetails.fltVat, 
                         tblOrderDetails.created_at, tblOrderDetails.updated_at, tblProducts.productCode, tblOrders.orderID, tblOrders.dteOrderDate, tblOrders.dteDeliveryDate, tblProducts.imageName, tblProducts.description, 
                         tblProducts.title, tblOrderDetails.fltQty * tblOrderDetails.fltPrice AS lineTot
FROM            tblOrderDetails INNER JOIN
                         tblProducts ON tblOrderDetails.strProductCode = tblProducts.productCode INNER JOIN
                         tblOrders ON tblOrderDetails.intOrderId = tblOrders.orderID
                                    WHERE        (tblOrders.orderID =  $orderId)");
        $total=0;
        foreach($items as $item){

            $total+=$item->fltPrice;
        }
        return view('cart',['items'=>$items,'total'=>$total]);
    }
}
