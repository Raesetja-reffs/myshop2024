<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     */
    public function __invoke(Logger $logger): void
    {
        $this->createNewLogFile();
        foreach ($logger->getHandlers() as $handler) {
            $format = "[%datetime%] %extra.company% %extra.userId% %channel%.%level_name%: %message% %context% %extra%\n";

            $handler->setFormatter(new LineFormatter(
                $format,
                'Y-m-d H:i:s',
                true, // allowInlineLineBreaks
                true,  // ignoreEmptyContextAndExtra
                true, //includeStacktraces
            ));

            $handler->pushProcessor(function ($record) {
                $company = null;
                $userId = null;
                if (config('app.IS_API_BASED') && auth()->guard('central_api_user')->user()) {
                    $userId = auth()->guard('central_api_user')->user()->id;
                    $company = [
                        'id' => auth()->guard('central_api_user')->user()->company_id,
                        'name' => auth()->guard('central_api_user')->user()->company_name,
                    ];
                }
                $record['extra']['company'] = $company;
                $record['extra']['userId'] = 'userId: ' . $userId;
                return $record;
            });
        }

    }

    /**
     * This function is used for create the new log file
     */
    protected function createNewLogFile()
    {
        $logFile = storage_path('logs/laravel.log');
        $maxFileSize = config('logging.max_file_size');

        if (file_exists($logFile) && filesize($logFile) > $maxFileSize) {
            $backupLogFile = storage_path('logs/laravel-' . date('Y-m-d_H-i-s') . '.log');
            rename($logFile, $backupLogFile);
            touch($logFile);
        }
    }
}
