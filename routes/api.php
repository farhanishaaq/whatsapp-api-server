<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chatrooms', [ChatroomController::class, 'create']);
    Route::get('/chatrooms', [ChatroomController::class, 'index']);
    Route::post('/chatrooms/{chatroom}/enter', [ChatroomController::class, 'enter']);
    Route::post('/chatrooms/{chatroom}/leave', [ChatroomController::class ,'leave']);
    Route::post('/chatrooms/{chatroom}/messages', [MessageController::class, 'send']);
    Route::get('/chatrooms/{chatroom}/messages',  [MessageController::class,'index']);
});

