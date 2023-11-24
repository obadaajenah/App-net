<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\FileController;

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




Route::group(['prefix'=>'user'],function(){

    Route::post('register', [Logincontroller::class,'register']);

    Route::post('login', [Logincontroller::class,'login']);

    Route::get('logout', [Logincontroller::class,'logout'])->middleware('check_user');
});


Route::get('download/{file_id}', [FileController::class, 'download']);
