<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 28/07/2017
 * Time: 03:54 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserFeature  extends Controller
{
    public function getDimsUsers()
    {
        $users = DB::connection('sqlsrv3')->table('tblDIMSUSERS')->select('UserID', 'UserName','Password', 'Administrator')->orderBy('UserName', 'asc')->get();
        return response()->json($users);
    }
}