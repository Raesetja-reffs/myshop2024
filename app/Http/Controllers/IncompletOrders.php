<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncompletOrders extends Controller
{
    //
    public function incompletOrders()
    {
        $userId = Auth::user()->strCustName;
        $incomplete= DB::connection('sqlsrv4')->select("SELECT Top 5 * FROM [Shop].[dbo].[tblOrders] Where blnComplete = 0 and strCustName='$userId' ORDER BY dteOrderDate desc");

        dd($incomplete);
    }
}
