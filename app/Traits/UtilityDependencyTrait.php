<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait UtilityDependencyTrait
{
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

    /**
     * This function is used for convert the single array to multiple array
     *
     * @param array $data
     */
    public function convertToMultipleArray($data)
    {
        if ($data && !isset($data[0])) {
            $data = [$data];
        }

        return $data;
    }
}
