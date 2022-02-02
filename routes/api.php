<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Api\Reuniones\ReunionesController;
use App\Http\Controllers\Api\Reuniones\ReunionesJoinController;

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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/reuniones/generate',[ReunionesController::class,"store"]);
    Route::get('/reuniones/unirse',[ReunionesJoinController::class,"index"]);
    Route::post('/reuniones/unirse',[ReunionesJoinController::class,"joining"]);
    Route::post('/reuniones/desconectarse',[ReunionesJoinController::class,"disconnect"]);
    Route::get('/reuniones', [ReunionesController::class,"index"]);
});
Broadcast::routes(['middleware' => ['auth:sanctum']]);