<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::resource('/topics', TopicController::class);
    Route::resource('/quizzes', QuizController::class);   
});

Route::get('/makeroom/{room}', [RoomController::class, 'makeRoom'])->name('room.make');
Route::get('/rooms/{room}', [RoomController::class, 'waitingRoom'])->name('room.waiting');

require __DIR__.'/auth.php';
