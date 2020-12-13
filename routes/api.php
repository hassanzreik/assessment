<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\Server;
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

Route::prefix('app')->group(function () {
	Route::get('products',  [Api\AppController::class, 'getProducts']);
	Route::get('operators',  [Api\AppController::class, 'getOperators']);
});

Route::prefix('user')->group(function () {
	Route::post('login',  [Api\UserController::class, 'login']);
	Route::post('register',  [Api\UserController::class, 'register']);

	Route::group(['middleware' => ['auth:api']], function () {
		Route::get('logout',  [Api\UserController::class, 'logout']);
		Route::get('profile',  [Api\UserController::class, 'profile']);

		Route::post('subscribe',  [Api\UserController::class, 'subscribe']);
		Route::post('unsubscribe',  [Api\UserController::class, 'unsubscribe']);
	});
});

Route::prefix('server')->group(function () {

	//Using ServerMiddleware to check server token is valid
	Route::group(['middleware' => ['server-auth']], function () {
		Route::get('subscribeCallback/{token}', [Server\SubscribeController::class, 'subscribeCallback']);
		Route::get('unsubscribeCallback/{token}', [Server\SubscribeController::class, 'unsubscribeCallback']);
	});
});