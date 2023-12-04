<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyPermissionController;

Route::middleware('auth')->group(function () {
    Route::get('company-permissions/set-permissions', [CompanyPermissionController::class, 'setPermissions'])->name('company-permissions.set-permissions');
    Route::post('company-permissions/save-permissions', [CompanyPermissionController::class, 'savePermissions'])->name('company-permissions.save-permissions');
});
