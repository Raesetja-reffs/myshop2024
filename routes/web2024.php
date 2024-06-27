<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyPermissionController;
use App\Http\Controllers\SalesForm;
use App\Http\Controllers\CentralUserController;

Route::middleware('auth:web,central_api_user')->group(function () {
    Route::get('company-permissions/set-permissions', [CompanyPermissionController::class, 'setPermissions'])
        ->name('company-permissions.set-permissions');
    Route::post('company-permissions/save-permissions', [CompanyPermissionController::class, 'savePermissions'])
        ->name('company-permissions.save-permissions');
    Route::resource('central-users', CentralUserController::class);
    Route::get('/central-users/reset-password/{centralUser}', [CentralUserController::class, 'resetPassword'])->name('central-users.reset.password');
    Route::post('/central-users/store/reset-password/{centralUser}', [CentralUserController::class, 'storeResetPassword'])->name('central-users.store.reset.password');
});

Route::get('/getSalesOrderCustomers', [SalesForm::class,'getSalesOrderCustomers'])->name('sales-order.get-sales-order-customers');
Route::get('/getSalesOrderProducts', [SalesForm::class,'getSalesOrderProducts'])->name('sales-order.get-sales-order-products');
