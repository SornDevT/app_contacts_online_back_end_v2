<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("register",[UserController::class,"register"]);
Route::post("login",[UserController::class,"login"]);
Route::get("logout",[UserController::class,"logout"]);

Route::get("check_user",[UserController::class,"check_user"]);         // ກວດຊອບ ຜູ້ໃຊ້ login
Route::get("user",[UserController::class,"index"]);         // ດຶງຜູ້ໃຊ້ທັງໝົດ
Route::get("user/{id}",[UserController::class,"user"]);     // ດຶງຜູ້ໃຊ້ ຕາມ id
Route::post("user",[UserController::class,"add_user"]);     // ເພີ່ມຂໍ້ມູນຜູ້ໃຊ້
Route::post("user/update/{id}",[UserController::class,"update_user"]);     // ອັບເດດຂໍ້ມູນຜູ້ໃຊ້
Route::delete("user/{id}",[UserController::class,"delete_user"]);     // ລຶບຂໍ້ມູນຜູ້ໃຊ້



