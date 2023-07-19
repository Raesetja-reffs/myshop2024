<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 06/10/2017
 * Time: 03:11 PM
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PalladiumDimsStatus extends Controller
{
    public function salesHeaderExported()
    {
        $returnStatus= DB::connection('sqlsrv3')->table('viewGetFailedToExport')
            ->select('DocNumber','DocDate','CustomerNumber','SoldTo','ShipTo','Total','intFlag','ErrorMessage','SupplierErrorMessage')
            ->where('intFlag','<>','1')->get();

        return response()->json($returnStatus);

    }
    public function updateSalesHeaderExportedStatus(Request $request)
    {
        $status = $request->get('headerStatus');
        $docNumber = $request->get('DocNumber');

        $return = DB::connection('sqlsrv3')->table('SalesInvoiceHeader')
            ->where('DocNumber', $docNumber)
            ->update(['intFlag' => $status,'intSupplierFlag' => $status]);
        if($return)
        {
            $return = ' has been changed to '.$status;
        }
        else{
            $return = 'Failed ,Please try again';
        }

        return response()->json($return);
    }
}