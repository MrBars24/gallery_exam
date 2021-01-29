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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user/{user_id}/albums', array('uses' => 'AlbumController@index'));
Route::put('/photo/{photo}', array('uses' => 'PhotoController@update'));
Route::delete('/photo/{photo}', array('uses' => 'PhotoController@destroy'));
Route::post('/photo', array('uses' => 'PhotoController@store'));
Route::get('/album/{album_id}/photos', array('uses' => 'PhotoController@index'));
Route::get('/photo/{photo}', array('uses' => 'PhotoController@show'));

Route::apiResource('persons', PersonController::class)->except([
    'store', 'update', 'destroy'
]);