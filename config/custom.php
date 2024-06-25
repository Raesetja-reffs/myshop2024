<?php

return [
    'pagination' => 10,
    'flash_messages' => [
        'create' => ' has been created successfully.',
        'update' => ' has been updated successfully.',
        'delete' => ' has been deleted successfully.',
        'is_active'=> ' is active so please deactivate first and try again!',
        'unauthorized' => 'You are not allow to edit this customer',
    ],
    'debug_log_message' => [
        'flowgear_api' => 'Flowgear API Response',
    ],
    'MAIN_API_URL' => env('MAIN_API_URL'),
    'MAIN_API_AUTHTOKEN' => env('MAIN_API_AUTHTOKEN'),
];
