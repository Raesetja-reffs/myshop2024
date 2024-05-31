<?php

namespace App\Traits;

trait UtilityTrait
{
    public function commonGetThings($thing)
    {
        $things = 0;
        if (config('app.IS_API_BASED')) {
            $things = $this->apiGetThings();
        } else {
            $GroupId = Auth::user()->GroupId;
            $returnTrueOrFalse = DB::connection('sqlsrv3')
                ->select("select [dbo].[fnGetGroupThings](".$GroupId.",'".$thing."',0) as things");
            foreach ($returnTrueOrFalse as $val) {
                $things = $val->things;
            }
        }

        return $things;
    }
}
