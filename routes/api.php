<?php

use App\Http\Controllers\Api\adminController;
use App\Http\Controllers\APi\loginController;
use App\Http\Controllers\TaskController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::post('/login', [loginController::class,'index']);
Route::middleware('auth:api')->group(function(){
    Route::get('/whois', [loginController::class,'whois']);
    Route::post('/add-member',[adminController::class,'addmember']);
    Route::post('/add-workspace',[adminController::class,'addworkspace']);
    Route::get('/get-workspace',[adminController::class,'getworkspace']);
    Route::get('/get-workspace/{name}',[adminController::class,'getworkspaceByName']);
    Route::delete('/task', [TaskController::class,'destroy']);
    Route::get('/task/workspace/{id}', [TaskController::class,'getbyworkspace']);
    Route::resource('/task', TaskController::class);
});

