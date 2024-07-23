<?php

$user_roles_values = [
    '1' => 'Super Admin',
    '2' => 'System Admin',
    '3' => 'Company Admin',
    '4' => 'Normal User',
];
$user_roles = [];
foreach ($user_roles_values as $roleId => $roleName) {
    $user_roles[] = [
        'id' => $roleId,
        'name' => $roleName,
    ];
}
$dims_report_values = [
    '1' => 'Order Invoice Report',
    '2' => 'Delivery Report',
];
$dims_report = [];
foreach ($dims_report_values as $key => $value) {
    $dims_report[] = [
        'id' => $key,
        'name' => $value,
    ];
}

return [
    'pagination' => 10,
    'flash_messages' => [
        'create' => ' has been created successfully.',
        'update' => ' has been updated successfully.',
        'delete' => ' has been deleted successfully.',
        'is_active'=> ' is active so please deactivate first and try again!',
        'unauthorized' => 'You are not allow to edit this customer',
        'error_contact_to_administrator' => 'There was a failure please contact to administrator or try to reload the page.',
    ],
    'debug_log_message' => [
        'flowgear_api' => 'Flowgear API Response',
    ],
    'MAIN_API_URL' => env('MAIN_API_URL'),
    'MAIN_API_AUTHTOKEN' => env('MAIN_API_AUTHTOKEN'),
    'user_roles' => $user_roles,
    'user_roles_values' => $user_roles_values,
    'default_user_role' => 4,
    'DIMS_REPORT_BUILDER_URL' => env('DIMS_REPORT_BUILDER_URL'),
    'execute_query_secret_key' => 'eyJpdiI6IlBVZnpIaEppeE5EYk5vVHR0K3k1clE9PSIsInZhbHVlIjoiekRSSm52bUh2cUhNT3Rlem8zQks1b1BRRHBqZTNQRU5iZG56VGtYd2FqNUZlMzYyRmlyY0RyVlMxV2cvVEZCNiIsIm1hYyI6IjZjN2QzNTQ2MGQyMDgyYWU4N2RlM2VjNzJkOGExOWU4MzMwNmRkMTkwYjhjNTM4ZTg5MDg2NzcxNmQyYjQwYjgiLCJ0YWciOiIifQ==',
    'dims_report' => $dims_report,
    'dims_report_values' => $dims_report_values,
];
