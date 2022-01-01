<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;

use App\Http\Controllers\RoomUserController;
use App\Http\Controllers\import\QuizImportController;
use App\Http\Controllers\import\UserImportController;
use App\Http\Controllers\import\TopicImportController;
use App\Http\Controllers\import\QuestionImportController;

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
// Route::middleware('verified')->group(function () {
    /*
    *  Route for user 
    */ 
    Route::middleware('user')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');
        Route::get('/home/{message?}', [HomeController::class, 'redirect'])->name('index.redirect');
        Route::get('/discover', [HomeController::class, 'discover'])->name('discover');
            
                // testing
                Route::get('/leaderboard', function () {
                    return view('leaderboard');
                });
                Route::get('/test/quiz', function () {
                    return view('quiz');
                });
                Route::get('/test/activity', function () {
                    return view('activity');
                })->name('test.activity');
                Route::get('/test/activity/made', function () {
                    return view('activity');
                })->name('test.activity.made');
            
                // testing admin 
                Route::get('/test/admin', function () {
                    return view('admin.dashboard');
                })->name('test.admin.dashboard');
                Route::get('/test/admin/topics', function () {
                    return view('admin.topics');
                })->name('test.admin.topics');

        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
            Route::get('/activity', [HomeController::class, 'activity'])->name('activity'); 
            Route::get('/activity/made', [HomeController::class, 'activitymade'])->name('activity.made'); 


            Route::prefix('/rooms')->group(function () {
                Route::post('/join/code', [RoomController::class, 'joinRoomWithCode'])->name('room.join-code'); // Not Tested Yet
                
                Route::prefix('/{quiz:slug}')->group(function () {
                    Route::get('/host/prewaiting', [RoomController::class, 'preWaitingHost'])->name('room.pre-waiting-host');
                    Route::get('/make', [RoomController::class, 'makeRoom'])->name('room.make');
                });

                
                Route::prefix('/{room:code}')->group(function () {
                    Route::get('/join/link', [RoomController::class, 'joinRoomWithLink'])->name('room.join-link');
                    Route::get('/enter', [RoomController::class, 'enterRoom'])->name('room.enter');
                    Route::get('/player/prewaiting', [RoomController::class, 'preWaitingPlayer'])->name('room.pre-waiting-player');
                    Route::get('/exit-game', [RoomController::class, 'exitGame'])->name('game.exit');

                    // Route::middleware(['waiting'])->group(function () {
                        Route::get('/start', [RoomController::class, 'startRoom'])->name('room.start');
                        Route::get('/waiting', [RoomController::class, 'waitingRoom'])->name('room.waiting');
                        Route::get('/exit', [RoomController::class, 'exitRoom'])->name('room.exit');
                    // });

                    Route::prefix('/question')->group(function () {
                        Route::get('/{order}', [RoomController::class, 'viewQuestion'])->name('question.view');
                        Route::post('/{order}', [RoomController::class, 'handleAnswer'])->name('question.handle');
                        Route::get('/{order}/leaderboard', [RoomController::class, 'leaderboard'])->name('question.leaderboard');
                        // for testing
                        // Route::get('/{order}/test', [RoomController::class, 'test'])->name('question.test');
                    });

                });
            });

            Route::get('/profiles/detail', [ProfileController::class, 'detailAccount'])->name('profile.detail-account');
            Route::put('/profiles/detail', [ProfileController::class, 'updateAccount'])->name('profile.update-account');
            Route::put('/profiles/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

            Route::get('/activity/done', [RoomUserController::class, 'getAllPlayedQuiz'])->name('roomuser.getallplayedquiz');
        });
    });
    // End Route User
        
    /*
    *  Route for Admin 
    */ 
    Route::middleware('admin')->group(function () {    
        Route::prefix('/admin')->group(function () {
            Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
            Route::resource('/topics', TopicController::class);
            Route::resource('/quizzes', QuizController::class); 
            Route::resource('/questions', QuestionController::class);
            Route::get('/users', [UserImportController::class, 'index'])->name('users.index');
            Route::get('/{user}/role/change', [UserImportController::class, 'changeRole'])->name('users.change-role');
        
            Route::prefix('/import')->group(function () {
                // Route::get('/users', [UserImportController::class, 'show'])->name('import.show.users');
                Route::post('/users', [UserImportController::class, 'store'])->name('import.store.users');
                Route::get('/{user}/role/change', [UserImportController::class, 'changeRole'])->name('import.change.users');
    
                Route::get('/topics', [TopicImportController::class, 'show'])->name('import.show.topics');
                Route::post('/topics', [TopicImportController::class, 'store'])->name('import.store.topics');
        
                Route::get('/quizzes', [QuizImportController::class, 'show'])->name('import.show.quizzes');
                Route::post('/quizzes', [QuizImportController::class, 'store'])->name('import.store.quizzes');
        
                Route::get('/questions', [QuestionImportController::class, 'show'])->name('import.show.questions');
                Route::post('/questions', [QuestionImportController::class, 'store'])->name('import.store.questions');
            });
        });

    });
    // End route admin
    
    Route::get('/logout', function(){
        Auth::logout();
        return redirect()->route('index');
    })->name('logout-anchor');
// });
require __DIR__.'/auth.php';