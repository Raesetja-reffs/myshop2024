<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POS extends Controller
{
    //

    public function viewassignuserstotill($dates)
    {

        $Date = (new \DateTime($dates))->format('Y-m-d');
        /*$tillusers=  DB::connection('sqlsrv3')
            ->select("select * from [viewPosTillStatus]");
			*/
        $tillusers=  DB::connection('sqlsrv3')
            ->select("exec [spPosDailyReport] '$Date'");
        $receipts=  DB::connection('sqlsrv3')
            ->select("exec [spPaidReceipts] '$Date'");

        $availabletills=  DB::connection('sqlsrv3')
            ->select("select strTill from tblPOSInfo WHERE strStatus='Available'");

        $username=  DB::connection('sqlsrv3')
            ->select("select UserName,[Password] from tblDIMSUSERS where blnIsPOSUser = 1");

        return view('dims/tillusers')
            ->with('tillusers', $tillusers)->with('availabletills',$availabletills)->with('usernames',$username)->with('delDate', $Date)->with('receipts',$receipts);

    }
    public function submittillusers(Request $request)
    {
        $username= $request->get('username');
        $till= $request->get('till');
        $floatamount = $request->get('floatamount');

        $assignningtils= DB::connection('sqlsrv3')
            ->select("Exec spAssignTillUsers ?,?,?,?",
                array($username,$till,$floatamount,"Assign"));

        return response()->json($assignningtils);
    }
    public function closedrawer(Request $request)
    {

        $till= $request->get('till');

        $assignningtils= DB::connection('sqlsrv3')
            ->select("Exec spAssignTillUsers ?,?,?,?",
                array("AA",$till,0,"Unassign"));

        return response()->json($assignningtils);
    }

}
