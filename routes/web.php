<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DropdownController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesPersonsController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
Route::middleware(['auth'])->group(function() {

    Route::prefix('home')->name('home.')->group( function() {
        Route::get('/', [HomeController::class, 'index'])->name('');

        Route::get('get-sales-report-summaries', [HomeController::class, 'getSalesReportSummaries'])->name('get-sales-report-summaries');
   });

   Route::prefix('dropdowns')->name('dropdowns.')->group( function() {
        Route::get('get-regencies/{provincyId}', [DropdownController::class, 'getRegencies'])->name('get-regencies');
    });
    Route::resource('dropdowns', DropdownController::class)->except(['show', 'create', 'update']);

    Route::resource('products', ProductController::class)->except(['show', 'create', 'update']);
    Route::resource('sales', SalesController::class)->except(['show', 'create', 'update']);
    Route::resource('sales-persons', SalesPersonsController::class)->except(['show', 'create', 'update']);

    // RESET PASSWORD
    Route::get('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset-password');
    Route::post('store-reset-password', [ResetPasswordController::class, 'storeResetPassword'])->name('store-reset-password');

    Route::resource('roles', RoleController::class)->except(['show', 'create', 'update']);
    Route::resource('permissions', PermissionController::class)->except(['show', 'create', 'update']);

    Route::prefix('users')->name('users.')->group( function() {
         Route::get('change-status', [UserController::class, 'getChangeStatus'])->name('change-status');
         Route::get('change-password/{user}', [UserController::class, 'changePassword'])->name('change-password');
         Route::post('update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    });
    Route::resource('users', UserController::class)->except(['show']);
});
