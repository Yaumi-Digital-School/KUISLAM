<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TopicController;

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

// For testing only
Route::resource('/topics', TopicController::class);
Route::resource('/quizzes', QuizController::class);
Route::post('/rooms/join', [RoomController::class, 'joinRoomWithCode'])->name('room.joincode');

// Untuk Route jangan taro disini mbak, soalnya ini untuk bikin API, bisa sih cuma kita ga implementasi pakai API
// Trus untuk scriptnya masih salah, ini laravel versi 5 kalau ga salah.
// saya coba pindahin ke web.php
// Route::get('question','QuestionController@index');
// Route::post('question','QuestionController@create');
// Route::put('/question/{id}','QuestionController@update');
// Route::delete('/question/{id}','QuestionController@delete');


