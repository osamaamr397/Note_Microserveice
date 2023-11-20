<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware'=>['api','JWTAuthMiddleware']],function (){
    Route::post('notes', [App\Http\Controllers\NoteController::class,'store']);
    Route::post('show-note', [App\Http\Controllers\NoteController::class,'show']);
    Route::post('delete-note', [App\Http\Controllers\NoteController::class,'destroy']);
    Route::post('update-note', [App\Http\Controllers\NoteController::class,'update']);





});
