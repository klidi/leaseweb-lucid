<?php

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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', 'Framework\Http\Controllers\Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Framework\Http\Controllers\Auth\ApiAuthController@register')->name('register.api');
    Route::post('/logout', 'Framework\Http\Controllers\Auth\ApiAuthController@logout')->name('logout.api');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('users/{user}')->name('users.')->group(function () {
        Route::get('servers', 'Framework\Http\Controllers\ServerController@index');
        Route::post('servers', 'Framework\Http\Controllers\ServerController@store');
        Route::get('servers/{server}', 'Framework\Http\Controllers\ServerController@show');
        Route::delete('servers/{server}', 'Framework\Http\Controllers\ServerController@delete');
    });
});
