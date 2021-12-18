<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomUserController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/discover', [HomeController::class, 'discover'])->name('discover');


    // testing
    Route::get('/user/waiting-room', function () {
        return view('user/waiting-room');
    });

    Route::get('/host/waiting-room', function () {
        return view('host/waiting-room');
    });

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    Route::resource('/topics', TopicController::class);
    
    Route::resource('/quizzes', QuizController::class);   
    
    Route::prefix('/rooms')->group(function () {
        Route::post('/join/code', [RoomController::class, 'joinRoomWithCode'])->name('room.join-code'); // Not Tested Yet
        
        Route::prefix('/{quiz}')->group(function () {
            Route::get('/host/prewaiting', [RoomController::class, 'preWaitingHost'])->name('room.pre-waiting-host');
            Route::get('/make', [RoomController::class, 'makeRoom'])->name('room.make');
        });

        Route::prefix('/{room}')->group(function () {
            Route::get('/start', [RoomController::class, 'startRoom'])->name('room.start');
            Route::get('/join/link', [RoomController::class, 'joinRoomWithLink'])->name('room.join-link');
            Route::get('/enter', [RoomController::class, 'enterRoom'])->name('room.enter');
            Route::get('/player/prewaiting', [RoomController::class, 'preWaitingPlayer'])->name('room.pre-waiting-player');
            Route::get('/waiting', [RoomController::class, 'waitingRoom'])->name('room.waiting');
            Route::get('/exit', [RoomController::class, 'exitRoom'])->name('room.exit');

            Route::get('/{order}', [RoomController::class, 'viewQuiz'])->name('room.view-quiz');
        });
    });

    Route::get('/profiles/detail', [ProfileController::class, 'detailAccount'])->name('profile.detail-account');
    Route::post('/profiles/detail', [ProfileController::class, 'updateAccount'])->name('profile.update-account');
    Route::post('/profiles/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    Route::get('/activity/done', [RoomUserController::class, 'getAllPlayedQuiz'])->name('roomuser.getallplayedquiz');

    Route::get("/logout", function(){
        Auth::logout();
        return redirect()->route('index');
    });
});

// Hasil perubahan route

Route::get('/questions', [QuestionController::class, 'index'])->name('question.list');
Route::post('/questions', [QuestionController::class, 'create'])->name('question.create');
Route::post('/questions/{id}/update', [QuestionController::class, 'update'])->name('question.update');
Route::post('/questions/{id}/delete', [QuestionController::class, 'delete'])->name('question.delete');

require __DIR__.'/auth.php';
