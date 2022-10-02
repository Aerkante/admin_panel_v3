<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::post('login/panel', [AuthController::class, 'loginPanel']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('forgot', [AuthController::class, 'forgot']);


    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('me', [AuthController::class, 'userProfile']);
    });
});
