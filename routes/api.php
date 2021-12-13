<?php

use App\Http\Controllers\admincontroller;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PesaDokterController;
use App\Http\Controllers\UsersController;
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

Route::post('/register', [UsersController::class, 'register']);
Route::get('/user', [UsersController::class, 'index']);
Route::post('/user/{uid}', [UsersController::class, 'destroy']);
Route::post('/updateauth', [UsersController::class, 'update']);
Route::post('/updatefoto/{uid}', [UsersController::class, 'updatefoto']);
Route::get('/detail/{uid?}', [UsersController::class, 'show']);

Route::post('/tambahdokter', [DokterController::class, 'store']);
Route::get('/getdokter', [DokterController::class, 'index']);
Route::get('/getjenis', [DokterController::class, 'getjenis']);
Route::post('/updatedokter', [DokterController::class, 'updatedokter']);
Route::post('/deletedokter', [DokterController::class, 'deletedokter']);
Route::get('/getdokters', [BookController::class, 'getdokter']);

Route::post('/pesandokter', [PesaDokterController::class, 'create']);
Route::get('/readdokter/{uid}', [PesaDokterController::class, 'index']);
Route::post('/updatepesan', [PesaDokterController::class, 'update']);
Route::post('/hapuspesan/{id}', [PesaDokterController::class, 'hapus']);

Route::post('/registeradmin',[admincontroller::class,'register']);
Route::post('/loginadmin',[admincontroller::class,'loginadmin']);