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
];
