<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 11/08/2017
 * Time: 02:05 PM
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  App\tblCompanyReports;
use Illuminate\Support\Facades\Auth;
class SalesQuotes extends controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }
    public function salesquote()
    {
        (new DimsCommon())->clearAllUserLocks();
        $queryCustomers =DB::connection('sqlsrv3')->table("vwTestTblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->where('StatusId',1)->orderBy('CustomerPastelCode','ASC')->get();
        $queryCustomersDontCareStatus =DB::connection('sqlsrv3')->table("vwTestTblCustomers" )->select('CustomerId','StoreName','CustomerPastelCode','CreditLimit','BalanceDue','UserField5','Email','Routeid','Discount','OtherImportantNotes','strRoute')->orderBy('CustomerPastelCode','ASC')->get();
        $deliverTypes = DB::connection('sqlsrv3')->table('tblOrderTypes')->select('OrderTypeId','OrderType')->get();
        $getDeliveryDates = DB::connection('sqlsrv3')->table('vwDistinctDelvDates')->select('DeliveryDate')->orderBy('DeliveryDate', 'desc')->get();
        $getRoutes =  DB::connection('sqlsrv3')->table('tblRoutes')->select('Routeid', 'Route')->where('NotInUse','0')->orderBy('Route', 'asc')->get();

        $marginType =  DB::connection('sqlsrv3')->table('tblCOMPANYREPORTS')->select('ReportType', 'Comment')->where('ReportName','marginCalculator')
            ->where('Function','1')
            ->get();


        switch ($marginType[0]->ReportType)
        {
            case 'marginType1':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->distinct()->get();
                break;
            case 'marginType2':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->distinct()->get();
                break;
            case 'marginType3':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->distinct()->get();
                break;
            case 'marginType4':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->orderBy('PastelCode','ASC')->distinct()->get();
                break;
            case 'marginType5':
                $queryProducts =DB::connection('sqlsrv3')->table("viewActiveProductWithVat" )->select('ProductId','PastelCode','PastelDescription','UnitSize','Tax','Cost','QtyInStock','Margin','Alcohol','Available')->distinct()->orderBy('PastelCode','ASC')->get();
                break;

        }

        $trueFalse =  DB::connection('sqlsrv3')->table('tblCOMPANYREPORTS')->select('ReportType', 'ReportName')->where('ReportName','True')
            ->orwhere('ReportName','False')
            ->get();
        $getLastInserted= DB::connection('sqlsrv3')
            ->select("Select * from viewGetLastInsertedOrderIdAndDeliveryDate");

        return view('dims/salesquote')->with('products',$queryProducts)
            ->with('trueOrFalse',$trueFalse)
            ->with('LastInserted',$getLastInserted)
            ->with('customers',$queryCustomers)
            ->with('customersDontcareStatus',$queryCustomersDontCareStatus)
            ->with('margin',$marginType[0]->ReportType)
            ->with('orderTypes',$deliverTypes)
            ->with('delivDates',$getDeliveryDates)
            ->with('routesNames',$getRoutes);
    }
    public function createQuotesHeader(Request $request)
    {
        $custCode= $request->get('custCode');
        $rawString= $request->get('rawString');
        $exp = tblCompanyReports::where('ReportType', "saleQuoteExpieration")->get();
        $auth=Auth::user()->UserID;

        if(strlen($custCode) > 1) {

            $CustomerId = DB::connection('sqlsrv3')->table('tblCustomers')->select('CustomerId')->where('CustomerPastelCode', $custCode)->get();
            $custId = $CustomerId[0]->CustomerId;
        }else{
            $custId = 0;
        }
        $insertOrderDetails = DB::connection('sqlsrv3')
            ->select("EXEC spSalesQuotesHeader ".$custId.",'".$exp[0]->ReportName ."',".$auth.",'".$rawString."',0,'Insert'");
        return response()->json($insertOrderDetails);
    }
    public function quoteToInvoice()
    {

    }
    public function generateSalesQuote(Request $request)
    {
        $productCode= $request->get('productCode');
        $Qty= $request->get('productQty');
        $productPrices = $request->get('productPrices');
        $productComment = $request->get('productComment');
        $salesQuoteID = $request->get('salesQuoteID');
        $saleQuoteDetailID = $request->get('saleQuoteDetailID');
        $unitSize= $request->get('unitSize');
        if(strlen($productCode) > 1 ) {

            if (strlen($saleQuoteDetailID) > 1) {
                $insertSalesQuoteDetails = DB::connection('sqlsrv3')
                    ->select("EXEC spSalesQuotesDetails " . $salesQuoteID . "," . $saleQuoteDetailID . ",'" . $productCode . "',
            " . $Qty . "," . $productPrices . ",'" . $productComment . "'," . $productPrices . ",'" . $unitSize . "','Insert'");
                $output['ID'] = 0;
            } else {
                $saleQuoteDetailID = "NULL";
                $insertSalesQuoteDetails = DB::connection('sqlsrv3')
                    ->select("EXEC spSalesQuotesDetails " . $salesQuoteID . "," . $saleQuoteDetailID . ",'" . $productCode . "',
            " . $Qty . "," . $productPrices . ",'" . $productComment . "','" . str_replace("'", " ", $unitSize) . "','Insert'");

                $output['ID'] = $insertSalesQuoteDetails[0]->ID;
            }
        }else{
            $output['ID'] = 0;
        }

    }
    public function previewSaleQuotes(Request $request)
    {
        $salesQuoteID = $request->get('saleQuoteID');
        $salesQuotePreview = DB::connection('sqlsrv3')->select("EXEC spSalesQuotesPreview ". $salesQuoteID );

        return response()->json($salesQuotePreview);
    }
    public function printTheQuote($quoteID)
    {
        $quoteHeader = DB::connection('sqlsrv3')->table('tblSalesQuoteHeader')->select('strRawString', 'blnIsChangedToInv')
            ->where('intSalesQuoteId',$quoteID)->get();

        return view('dims/salesquoteprint')->with('id',$quoteID)->with('quoteHeader',$quoteHeader);
    }
    public function viewSalesQuotes(Request $request)
    {
        $columns = array(
            0 =>'intSalesQuoteId',
            1 =>'strRawString',
            2=> 'blnIsChangedToInv',
            3=> 'UserName',
            4=> 'CustomerPastelCode',
            5=> 'StoreName',
            6=> 'dteCreatedDate',
        );
       /* $limit = $request->input('length');
        $start = $request->input('start');*/
      //  $order = $columns[$request->input('order.0.column')];
       /* $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');*/
/*
        $quoteHeader = DB::connection('sqlsrv3')->select("SELECT [intCustId],[CustomerPastelCode],[StoreName],[intCreator],[UserName]
                                ,[dteCreatedDate],[strRawString],[blnIsChangedToInv],[strExpire],[intSalesQuoteId] FROM vwSalesQuoteHeader 
                                WHERE CustomerPastelCode <>'' AND blnIsChangedToInv=0 AND  (intSalesQuoteId like '%{$search}%' or strRawString like '%{$search}%' or StoreName like '%{$search}%' or
                                CustomerPastelCode like '%{$search}%') ORDER BY $order $dir OFFSET $start ROWS FETCH NEXT $limit ROWS ONLY");

        $countFiltered= DB::connection('sqlsrv3')->select("SELECT [intSalesQuoteId]FROM vwSalesQuoteHeader 
                                WHERE CustomerPastelCode <>'' AND blnIsChangedToInv=0 AND  (intSalesQuoteId like '%{$search}%' or strRawString like '%{$search}%' or StoreName like '%{$search}%' or
                                CustomerPastelCode like '%{$search}%')");*/

        $quoteHeader = DB::connection('sqlsrv3')->select("SELECT [intCustId],[CustomerPastelCode],[StoreName],[intCreator],[UserName]
                                ,[dteCreatedDate],[strRawString],[blnIsChangedToInv],[strExpire],[intSalesQuoteId] FROM vwSalesQuoteHeader 
                                WHERE CustomerPastelCode <>'' AND blnIsChangedToInv=0 ");

        $countFiltered= DB::connection('sqlsrv3')->select("SELECT [intSalesQuoteId]FROM vwSalesQuoteHeader 
                                WHERE CustomerPastelCode <>'' AND blnIsChangedToInv=0 order by intSalesQuoteId ");
        $output['recordsTotal'] = count($quoteHeader);
        $output['data'] = $quoteHeader;
        $output['recordsFiltered'] = count($countFiltered);

        $output['draw'] = intval($request->input('draw'));

        return $output;

    }
    public function viewSalesQuotesConverted(Request $request)
    {
        $columns = array(
            0 =>'intSalesQuoteId',
            1 =>'strRawString',
            2=> 'blnIsChangedToInv',
            3=> 'UserName',
            4=> 'CustomerPastelCode',
            5=> 'StoreName',
            6=> 'dteCreatedDate',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $quoteHeader = DB::connection('sqlsrv3')->select("SELECT [intCustId],[CustomerPastelCode],[StoreName],[intCreator],[UserName]
                                ,[dteCreatedDate],[strRawString],[blnIsChangedToInv],[strExpire],[intSalesQuoteId] FROM vwSalesQuoteHeader 
                                WHERE CustomerPastelCode <>'' AND blnIsChangedToInv=1 AND  (intSalesQuoteId like '%{$search}%' or strRawString like '%{$search}%' or StoreName like '%{$search}%' or
                                CustomerPastelCode like '%{$search}%') ORDER BY $order $dir OFFSET $start ROWS FETCH NEXT $limit ROWS ONLY");

        $countFiltered= DB::connection('sqlsrv3')->select("SELECT [intSalesQuoteId]FROM vwSalesQuoteHeader 
                                WHERE CustomerPastelCode <>'' AND blnIsChangedToInv=1 AND  (intSalesQuoteId like '%{$search}%' or strRawString like '%{$search}%' or StoreName like '%{$search}%' or
                                CustomerPastelCode like '%{$search}%')");
        $output['recordsTotal'] = count($quoteHeader);
        $output['data'] = $quoteHeader;
        $output['recordsFiltered'] = count($countFiltered);

        $output['draw'] = intval($request->input('draw'));

        return $output;

    }
    public function startConvertingQuoteToOrder(Request $request)
    {
        $salesQuoteID = $request->get('saleQuoteID');
        $routeId = $request->get('routeId');
        $deliveryDate = $request->get('deliveryDate');
        $orderType = $request->get('orderType');
        $salesQuotePreview = DB::connection('sqlsrv3')->select("EXEC spChangeSalesQuoteToOrder ". $routeId.",'".$deliveryDate."',".$orderType.",".$salesQuoteID );
        return response()->json($salesQuotePreview);
    }

}