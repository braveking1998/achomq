<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\SubmitQuestionController;
use App\Http\Controllers\Admin\UploadPublicImagesController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MultiPlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SinglePlayerController;
use App\Http\Controllers\UploadPrivateImagesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::name('guest.')->group(function () {
    Route::get(
        '/',
        fn () => Inertia::render('FrontPage', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'LaravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ])
    )->name('front');
    Route::get('/about', fn () => Inertia::render('About'))->name('about');
    Route::get('/contact', fn () => Inertia::render('Contact'))->name('contact');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::put('/', [ProfileController::class, 'updateProfileImage'])->name('update.image');
    Route::resource('images', UploadPrivateImagesController::class)->only(['store', 'destroy']);
});

require __DIR__.'/auth.php';

// Messages
Route::resource('messages', MessagesController::class)
    ->only(['index'])
    ->middleware('auth');

// Questions
Route::resource('questions', QuestionController::class)
    ->middleware('auth');

// Single player
Route::middleware('auth')
    ->name('single-player.')
    ->group(function () {
        Route::get('/single-player', [SinglePlayerController::class, 'category'])->name('category');
        Route::post('/single-player', [SinglePlayerController::class, 'index'])->name('quiz');
        Route::put('/single-player', [SinglePlayerController::class, 'result'])->name('result');
    });

// Multi player
Route::middleware('auth')
    ->name('multi-player.')
    ->prefix('multi-player')
    ->group(function () {
        Route::get('/', [MultiPlayerController::class, 'index'])->name('index');
        Route::post('/create/{type}', [MultiPlayerController::class, 'create'])->name('create');
        Route::get('/play/{game}', [MultiPlayerController::class, 'play'])->name('play');
        Route::get('/play/{game}/category', [MultiPlayerController::class, 'categoryLoad'])->name('categoryLoad');
        Route::post('/play/{game}/category', [MultiPlayerController::class, 'category'])->name('category');
        Route::get('/play/{game}/quiz', [MultiPlayerController::class, 'quizLoad'])->name('quizLoad');
        Route::post('/play/{game}/quiz', [MultiPlayerController::class, 'setQuiz'])->name('setQuiz');
        Route::put('/play/{game}/quiz', [MultiPlayerController::class, 'quiz'])->name('quiz');
        Route::patch('/play/{game}', [MultiPlayerController::class, 'result'])->name('result');
    });

// Debog
Route::get('/debug', [DebugController::class, 'index'])->name('debug');

// Admin
Route::middleware(['auth', 'verified', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', AdminController::class)->name('index');
    Route::resource('submit', SubmitQuestionController::class)
        ->only(['edit', 'update', 'destroy']);
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::resource('category', CategoryController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('level', LevelController::class)->only(['index', 'store', 'edit', 'update']);
        Route::get('/stats', StatsController::class)->name('stats');
        Route::resource('images', UploadPublicImagesController::class)->only(['index', 'store', 'destroy']);
    });
});
