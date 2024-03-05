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

// Auth with Sanctum
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginController@login');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('', 'ProductController@index');
    Route::get('{product}', 'ProductController@show');
    Route::post('', 'ProductController@store');
    Route::patch('{product}', 'ProductController@update');
    Route::delete('{product}', 'ProductController@delete');
});

// Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('profile', 'ProfileController@index');
});
