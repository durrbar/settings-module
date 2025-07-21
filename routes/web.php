<?php

use Illuminate\Support\Facades\Route;
use Modules\Role\Enums\Permission;
use Modules\Settings\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::apiResource('settings', SettingsController::class, [
    'only' => ['index'],
]);

/**
 * *****************************************
 * Authorized Route for Super Admin only
 * *****************************************
 */
Route::group(['middleware' => ['permission:'.Permission::SUPER_ADMIN, 'auth:sanctum']], function (): void {
    Route::apiResource('settings', SettingsController::class, [
        'only' => ['store'],
    ]);
});
