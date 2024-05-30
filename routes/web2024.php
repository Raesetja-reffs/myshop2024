<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyPermissionController;
use App\Http\Middleware\AuthenticateUsersAndCentralUser;
use App\Http\Controllers\SalesForm;

Route::middleware('auth')->group(function () {
    Route::get('company-permissions/set-permissions', [CompanyPermissionController::class, 'setPermissions'])->name('company-permissions.set-permissions');
    Route::post('company-permissions/save-permissions', [CompanyPermissionController::class, 'savePermissions'])->name('company-permissions.save-permissions');
});

Route::get('/getSalesOrderCustomers', [SalesForm::class,'getSalesOrderCustomers'])->name('sales-order.get-sales-order-customers');
Route::get('/getSalesOrderProducts', [SalesForm::class,'getSalesOrderProducts'])->name('sales-order.get-sales-order-products');
