<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Products;
use Illuminate\Support\Facades\DB;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = "H011";
        $dimsCustName = "ADM003";
        $array = array();
        //$userId = Auth::user()->strCustName;
        /*To bE REMOVED*/
        $topInvoice =DB::connection('sqlsrv3')->select("SELECT TOP (10) tblOrders.InvoiceNo as invoiceNo
                                                        FROM tblOrders INNER JOIN
                                                        tblCustomers ON tblOrders.CustomerId = tblCustomers.CustomerId
                                                       WHERE (tblOrders.Invoiced = 1) and tblCustomers.CustomerPastelCode='$dimsCustName'");
        //dd($topInvoice);
        foreach ($topInvoice as $value)
        {
            $array[]=$value->invoiceNo;
        }
      $implode = implode("','", $array);
        //dd($implode);
        $invoices =DB::connection('sqlsrv3')->select("SELECT tblOrders.OrderId, tblOrders.CustomerId, tblOrders.OrderDate, tblOrders.DeliveryDate, tblOrders.OrderNo, tblOrders.Invoiced, tblOrders.InvoiceNo, tblCustomers.CustomerPastelCode, tblCustomers.StoreName, 
                         tblOrderDetails.Qty, tblProducts.PastelCode, tblProducts.PastelDescription
FROM            tblOrders INNER JOIN
                         tblCustomers ON tblOrders.CustomerId = tblCustomers.CustomerId INNER JOIN
                         tblOrderDetails ON tblOrders.OrderId = tblOrderDetails.OrderId INNER JOIN
                         tblProducts ON tblOrderDetails.ProductId = tblProducts.ProductId
WHERE        (tblOrders.InvoiceNo in('$implode'))
GROUP by
 tblOrders.OrderId, tblOrders.CustomerId, tblOrders.OrderDate, tblOrders.DeliveryDate, tblOrders.OrderNo, tblOrders.Invoiced, tblOrders.InvoiceNo, tblCustomers.CustomerPastelCode, tblCustomers.StoreName, 
                         tblOrderDetails.Qty, tblProducts.PastelCode, tblProducts.PastelDescription
 ORDER BY tblOrders.DeliveryDate DESC");
//dd($invoices);
        //
        $orderPattern =DB::connection('sqlsrv3')->select("SELECT  tblCustomerDefaultOrders.ID, tblCustomerDefaultOrders.CustomerId, tblCustomerDefaultOrders.DeliveryAddressId, tblCustomerDefaultOrders.ProductId, tblCustomerDefaultOrders.Qty, 
                         tblCustomerDefaultOrders.FactorType, tblCustomerDefaultOrders.Factor, tblCustomerDefaultOrders.Avg, tblCustomerDefaultOrders.PushProduct, tblCustomerDefaultOrders.TrendingId, 
                         tblCustomerDefaultOrders.[2WeekAvg], tblCustomerDefaultOrders.InvoiceValue, tblCustomers.CustomerPastelCode, tblProducts.PastelCode, tblProducts.PastelDescription
FROM            tblCustomerDefaultOrders INNER JOIN
                         tblCustomers ON tblCustomerDefaultOrders.CustomerId = tblCustomers.CustomerId INNER JOIN
                         tblProducts ON tblCustomerDefaultOrders.ProductId = tblProducts.ProductId
WHERE        (tblCustomers.CustomerPastelCode = '$userId')
ORDER BY tblCustomerDefaultOrders.CustomerId");
        $allProducts=DB::connection('sqlsrv3')->select("select * from viewWebStorePriceLists where CustomerPastelCode='$dimsCustName'");
        if($request->has('search')){
            $user =DB::connection('sqlsrv4')->select("select * from tblProducts where title LIKE '%".$request->input('search')."%' or [description] LIKE '%".$request->input('search')."%'");
            //$user =DB::connection('sqlsrv')->table('tblProducts')->where ( 'title', 'LIKE', '%' . $request->input('search') . '%' )->orWhere ( 'description', 'LIKE', '%' .$request->input('search')  . '%' )->get ();

            if (count ( $user ) > 0) {
                return view('home')->with(['pattern' => $orderPattern,'invoices'=>$invoices])->withDetails($user)->withQuery('The Search results for '.$request->input('search'));
            }
            else
                return view ( 'home' )->with(['pattern' => $orderPattern,'invoices'=>$invoices])->withDetails($user)->withQuery('No Details found. Try to search again !' );

          //  $items = Products::search($request->input('search'))->toArray();
        }else
        {

            return view('home')->with(['pattern' => $orderPattern,'invoices'=>$invoices,'products'=>$allProducts]);
        }

    }
    public function show($slug)
    {
        //this must come from palladium
        $product = DB::connection('sqlsrv4')->select("select * from tblProducts where productCode = '".$slug."'");
       // dd($product);
        $interested = DB::connection('sqlsrv4')->select("select TOP 2 * from tblProducts where productCode = '".$slug."'");

        return view('product_selected')->with(['product' => $product[0], 'interested' => $interested]);
    }

}
