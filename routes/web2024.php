<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyPermissionController;
use App\Http\Middleware\AuthenticateUsersAndCentralUser;
use App\Http\Controllers\SalesForm;
use App\Http\Controllers\CentralUserController;
use App\Http\Controllers\GRVController;

Route::middleware('db_api_auth')->group(function () {
    Route::get('company-permissions/set-permissions', [CompanyPermissionController::class, 'setPermissions'])
        ->name('company-permissions.set-permissions');
    Route::post('company-permissions/save-permissions', [CompanyPermissionController::class, 'savePermissions'])
        ->name('company-permissions.save-permissions');
    Route::resource('central-users', CentralUserController::class);
    Route::get('/central-users/reset-password/{centralUser}', [CentralUserController::class, 'resetPassword'])->name('central-users.reset.password');
    Route::post('/central-users/store/reset-password/{centralUser}', [CentralUserController::class, 'storeResetPassword'])->name('central-users.store.reset.password');

    Route::get('grv', [GRVController::class, 'dashboard'])->name('grv.dashboard');
    Route::get('grv/not-received-pos', [GRVController::class, 'notReceivedPOs'])->name('grv.not-received-pos');
    Route::get('grv/awaiting-auth', [GRVController::class, 'awaitingAuth'])->name('grv.awaiting-auth');
    Route::get('grv/received', [GRVController::class, 'received'])->name('grv.received');
    Route::get('grv/queries', [GRVController::class, 'queries'])->name('grv.queries');
    Route::get('grv/issues', [GRVController::class, 'issues'])->name('grv.issues');
});

Route::get('/getSalesOrderCustomers', [SalesForm::class,'getSalesOrderCustomers'])->name('sales-order.get-sales-order-customers');
Route::get('/getSalesOrderProducts', [SalesForm::class,'getSalesOrderProducts'])->name('sales-order.get-sales-order-products');
