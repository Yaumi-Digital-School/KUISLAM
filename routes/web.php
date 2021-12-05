<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomUserController;
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
})->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    Route::resource('/topics', TopicController::class);
    
    Route::resource('/quizzes', QuizController::class);   
    
    Route::prefix('/rooms')->group(function () {
        Route::get('/join', [RoomController::class, 'enterCode'])->name('room.entercode');
        Route::post('/join', [RoomController::class, 'joinRoomWithCode'])->name('room.joincode'); // Not Tested Yet
        
        Route::prefix('/{quiz}')->group(function () {
            Route::get('/make', [RoomController::class, 'makeRoom'])->name('room.make');
        });

        Route::prefix('/{room}')->group(function () {
            Route::get('/join', [RoomController::class, 'joinRoomWithLink'])->name('room.joinlink');
            Route::get('/waiting', [RoomController::class, 'waitingRoom'])->name('room.waiting');
            Route::get('/exit', [RoomController::class, 'exitRoom'])->name('room.exit');
        });
    });
    Route::get('/profiles/detail', [ProfileController::class, 'detailAccount'])->name('profile.detailaccount');
    Route::post('/profiles/detail', [ProfileController::class, 'updateAccount'])->name('profile.updateaccount');

    Route::get('/activity/done', [RoomUserController::class, 'getAllPlayedQuiz'])->name('roomuser.getallplayedquiz');
});




require __DIR__.'/auth.php';
