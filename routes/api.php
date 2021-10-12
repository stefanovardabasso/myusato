<?php

use Illuminate\Http\Request;

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


Route::get('getoffertsrelations', ['uses' => 'Admin\OffertController@getoffertsrelations', 'as' => 'addproduct']);
Route::get('deleterelation', ['uses' => 'Admin\OffertController@deleterelation', 'as' => 'deleterelation']);

Route::post('auth/token', ['uses' => 'Admin\SapController@access', 'as' => 'auth/token']);

Route::post('test', ['uses' => 'Admin\SapController@insert', 'as' => 'test']);

Route::post('addcomponents', ['uses' => 'Admin\ComponentController@addcomponents', 'as' => 'addcomponents']);
Route::get('getcomponents', ['uses' => 'Admin\ComponentController@getcomponents', 'as' => 'getcomponents']);
Route::get('deletecomponents', ['uses' => 'Admin\ComponentController@deletecomponents', 'as' => 'deletecomponents']);
Route::get('deleteimage', ['uses' => 'Admin\OffertController@deleteimage', 'as' => 'deleteimage']);

Route::post('checkbydate', ['uses' => 'Admin\HomeController@checkbydate', 'as' => 'checkbydate']);

