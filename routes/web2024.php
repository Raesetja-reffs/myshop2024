<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyPermissionController;
use App\Http\Controllers\GRVController;

Route::middleware('auth')->group(function () {
    Route::get('company-permissions/set-permissions', [CompanyPermissionController::class, 'setPermissions'])->name('company-permissions.set-permissions');
    Route::post('company-permissions/save-permissions', [CompanyPermissionController::class, 'savePermissions'])->name('company-permissions.save-permissions');
    Route::get('grv', [GRVController::class, 'dashboard'])->name('grv.dashboard');
    Route::get('grv/not-received-pos', [GRVController::class, 'notReceivedPOs'])->name('grv.not-received-pos');
    Route::get('grv/awaiting-auth', [GRVController::class, 'awaitingAuth'])->name('grv.awaiting-auth');
    Route::get('grv/received', [GRVController::class, 'received'])->name('grv.received');
    Route::get('grv/queries', [GRVController::class, 'queries'])->name('grv.queries');
    Route::get('grv/issues', [GRVController::class, 'issues'])->name('grv.issues');
});
