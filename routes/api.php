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
Route::apiResource('/user/{user_id}/albums', UserAlbumController::class);
Route::apiResource('/user/{user_id}/photos', UserPhotoController::class);
Route::apiResource('user', PersonController::class);

Route::apiResource('album', AlbumController::class);
Route::apiResource('album/{album_id}/photos', AlbumPhotoController::class);

Route::apiResource('photo', PhotoController::class);
