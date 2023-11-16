<?php

use App\Http\Controllers\productosController;
use App\Http\Controllers\usersController;
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
Route::get('get_datauser' , [usersController::class, 'dataUser']);

Route::get('/create', [usersController::class, 'create']);

Route::get('get_dataproduc' , [productosController::class, 'dataproduc']);

 