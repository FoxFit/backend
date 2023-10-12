<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function ($router) {
    $router->post('login', [AuthController::class, 'login'])->name('login');
    $router->post('register', [AuthController::class, 'register'])->name('register');

    $router->get('check', [AuthController::class, 'check'])->name('check');

    Route::group(['middleware' => ['auth:api']], function ($router) {
        $router->get('logout', [AuthController::class, 'logout'])->name('logout');
        $router->get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::resource('user', UserController::class);
        $router->post('import-user', [ExcelController::class, 'importExcelUser'])->name('importUser');
    });
});

Route::group(['middleware' => ['auth:api']], function ($router) {
    $router->get('customers', [UserController::class, 'index'])->name('customers');
});


