<?php

use App\Events\chat;
use App\Events\GlobalMessage;
use App\Events\Notif;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    dd('ddd');
});
Route::get('/text',function(){
    GlobalMessage::dispatch([
        'message' => "hai",
        'from'    => 'admin',
        'type'    => 'normal',
        'reply'   => false,
        'time'    => 'dasdwmnamnsdmas'
    ]);
});
Route::get('/chat/{id}',function($id){
    chat::dispatch($id,[
        'message' => "hai",
        'from'    => 'mes',
        'type'    => 'normal',
        'reply'   => false,
        'time'    => 'dasdwmnamnsdmas'
    ]);
});
Route::get('/notif/{id}',function($id){
    Notif::dispatch($id,[
        'message'    => "hai",
        'from'       => 'mes',
        'assigment'  => false,
        'time'       => 'dasdwmnamnsdmas'
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/task', TaskController::class);
