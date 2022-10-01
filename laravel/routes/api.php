<?php

use App\Http\Controllers\Auth\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('login/panel', [AuthController::class, 'loginPanel']);

    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('forgot', [AuthController::class, 'forgot']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('me', [AuthController::class, 'userProfile']);
        Route::post('upload-avatar', [UserController::class, 'uploadAvatar']);
        Route::get('delete-account', [AuthController::class, 'deleteAccount']);
    });
});
