<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait UtilityTrait
{
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

    public function apiOrdersExport($data)
    {
        return $this->httpRequest('post', 'Post_RetrieveOrderLineForExcel', $data);
    }

    /**
     * This function is used for convert the array to collection object
     *
     * @param array $data
     */
    public function convertToCollectionObject($data)
    {
        return collect($data)->map(function ($item) {
            return (object) $item;
        });
    }
}
