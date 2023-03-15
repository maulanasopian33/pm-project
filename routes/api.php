<?php

use App\Http\Controllers\APi\adminController;
use App\Http\Controllers\APi\loginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Pusher\PushNotifications\PushNotifications;
use Pusher\Pusher;
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
    Route::post('/add-member',[adminController::class,'addteam']);
    Route::get('/get-team',[adminController::class,'getteam']);
    Route::post('/add-workspace',[adminController::class,'addworkspace']);
    Route::get('/get-workspace',[adminController::class,'getworkspace']);
    Route::resource('/task', TaskController::class);
    Route::post('/todo', [TodoController::class,'store']);
    Route::get('/todo/{id}', [TodoController::class,'index']);
    Route::post('/todo/update', [TodoController::class,'updates']);
    Route::delete('/todo/{id}', [TodoController::class,'destroy']);
    Route::get('/task/workspace/{id}',[TaskController::class, 'getbyworkspace']);
    Route::get('/task/bytask/{id}',[TaskController::class, 'getbytask']);
    Route::post('/task/{id}',[TaskController::class, 'update']);
    Route::post('/chat/{channel}',[ChatController::class,'store']);
    Route::get('/chat/{id}',[ChatController::class,'index']);
});


Route::post('/pusher/auth', function (Request $request) {
    // $user = Auth::user();

    // if (!$user) {
    //     return response()->json(['error' => 'Unauthorized'], 401);
    // }

    $options = array(
        'cluster' => 'PUSHER_APP_CLUSTER',
        'useTLS' => true
    );
    $pusher = new Pusher(
        '94e6a87800b6adf547b1',
        'ccd1ff026000d4d49edf',
        '1558044',
        $options
    );

    $socket_id = $request->socket_id;
    $channel_name = $request->channel_name;
    $auth = $pusher->socket_auth($channel_name, $socket_id, json_encode(['user_id' => $request->id]));

    return response($auth);
});

Route::post('/send-notification', function (Request $request) {
    $beamsClient = new PushNotifications([
        "instanceId" => "2ba8fe30-0926-4eb5-8310-2e350311ebc3",
        "secretKey" => "74E11C36030A9A657A6CC9648CB2C4047384892CCE17135C1057E042C711899C",
    ]);

    $publishResponse = $beamsClient->publishToInterests(
        ["hello"],
        [
            "web" => [
                "notification" => [
                    "title" => $request->input('title'),
                    "body" => $request->input('body'),
                ],
            ],
        ]
    );

    return response()->json(['success' => true]);
});
