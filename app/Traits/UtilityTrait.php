<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\SalesFormTrait;

trait UtilityTrait
{
    use SalesFormTrait;

    public function commonGetThings($thing, $groupId = null)
    {
        $things = 0;
        if (config('app.IS_API_BASED')) {
            $things = $this->apiGetThings([
                'Content' => $thing
            ]);
        } else {
            if (!$groupId) {
                $groupId = Auth::user()->GroupId;
            }
            $returnTrueOrFalse = DB::connection('sqlsrv3')
                ->select("select [dbo].[fnGetGroupThings](" . $groupId . ",'" . $thing . "',0) as things");
            foreach ($returnTrueOrFalse as $val) {
                $things = $val->things;
            }
        }

        return $things;
    }

    /**
     * This function is used for save the laravel debug log
     *
     * @param string $message
     * @param any $context
     */
    public function saveDebugLog($message, $context)
    {
        if (is_object($context)) {
            $context = (array) $context;
        } elseif (!is_array($context)) {
            $context = [$context];
        }

        Log::debug($message, $context);
    }

    public function apiOrdersExport()
    {
        return [];
    }
}
