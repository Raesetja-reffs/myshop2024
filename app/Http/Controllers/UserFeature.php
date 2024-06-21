<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Traits\UserFeatureTrait;

class UserFeature extends Controller
{
    use UserFeatureTrait;

    public function getDimsUsers()
    {
        if (config('app.IS_API_BASED')) {
            $users = $this->apiGetDimsUsers();
        } else {
            $users = DB::connection('sqlsrv3')
                ->table('tblDIMSUSERS')
                ->select('UserID', 'UserName','Password', 'Administrator')
                ->orderBy('UserName', 'asc')
                ->get();
        }

        return response()->json($users);
    }
}
