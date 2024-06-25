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
}
