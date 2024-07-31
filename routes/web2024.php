<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyPermissionController;
use App\Http\Controllers\SalesForm;
use App\Http\Controllers\CentralUserController;
use App\Http\Controllers\JasperReports;
use App\Http\Controllers\LaravelLogController;
use App\Http\Controllers\ReportBuilderFileController;

Route::middleware('auth:web,central_api_user')->group(function () {

    Route::resource('company-permissions', CompanyPermissionController::class)->only(['index']);
    Route::get('company-permissions/get-roles/{companyId}', [CompanyPermissionController::class, 'getRoles'])->name('company-permissions.get-roles');
    Route::get('company-permissions/set-permissions', [CompanyPermissionController::class, 'setPermissions'])
        ->name('company-permissions.set-permissions');
    Route::post('company-permissions/save-permissions', [CompanyPermissionController::class, 'savePermissions'])
        ->name('company-permissions.save-permissions');

    Route::resource('central-users', CentralUserController::class);
    Route::get('/central-users/reset-password/{centralUser}', [CentralUserController::class, 'resetPassword'])->name('central-users.reset.password');
    Route::post('/central-users/store/reset-password/{centralUser}', [CentralUserController::class, 'storeResetPassword'])->name('central-users.store.reset.password');

    Route::get('/report-builder-files/download-sample-file/{reportType}', [ReportBuilderFileController::class, 'downloadSampleFile'])->name('report-builder-files.download-sample-file');
    Route::resource('report-builder-files', ReportBuilderFileController::class);

    Route::get('/getSalesOrderCustomers', [SalesForm::class,'getSalesOrderCustomers'])->name('sales-order.get-sales-order-customers');
    Route::get('/getSalesOrderProducts', [SalesForm::class,'getSalesOrderProducts'])->name('sales-order.get-sales-order-products');
    Route::get('/getSalesOrderProductsBasedOnCustomerCode', [SalesForm::class,'getSalesOrderProductsBasedOnCustomerCode'])->name('sales-order.get-sales-order-products-based-on-customercode');

    Route::get('/logs', [LaravelLogController::class,'index'])->name('laravel.log');
});

Route::get('/order/getPdfData', [JasperReports::class,'getPdfDataFromApi'])->name('order.get-pdf-data');
