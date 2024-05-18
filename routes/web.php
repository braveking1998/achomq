<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\MultiController;
use App\Http\Controllers\SingleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\QuestionManagementController;
use App\Http\Controllers\UploadPrivateImagesController;
use App\Http\Controllers\Admin\SubmitQuestionController;
use App\Http\Controllers\Admin\UploadPublicImagesController;
use App\Http\Controllers\FrontController;

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
    Route::get('/', FrontController::class)->name('front');
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

require __DIR__ . '/auth.php';

// Messages
Route::resource('messages', MessageController::class)
    ->middleware('auth');

// Questions
Route::resource('questions', QuestionController::class)
    ->middleware('auth');

// Single player
Route::middleware('auth')
    ->name('single.')
    ->prefix('single')
    ->group(function () {
        Route::get('/', [SingleController::class, 'index'])->name('index');
        Route::post('/', [SingleController::class, 'quiz'])->name('quiz');
        Route::put('/', [SingleController::class, 'result'])->name('result');
    });

// Multi player
Route::middleware('auth')
    ->name('multi.')
    ->prefix('multi')
    ->group(function () {
        Route::get('/', [MultiController::class, 'index'])->name('index');
        Route::post('/create/{type}', [MultiController::class, 'create'])->name('create');
        Route::get('/play/{game}', [MultiController::class, 'play'])->name('play');
        Route::get('/play/{game}/category', [MultiController::class, 'categoryLoad'])->name('categoryLoad');
        Route::post('/play/{game}/category', [MultiController::class, 'category'])->name('category');
        Route::get('/play/{game}/quiz', [MultiController::class, 'quizLoad'])->name('quizLoad');
        Route::post('/play/{game}/quiz', [MultiController::class, 'setQuiz'])->name('setQuiz');
        Route::put('/play/{game}/quiz', [MultiController::class, 'quiz'])->name('quiz');
        Route::patch('/play/{game}', [MultiController::class, 'result'])->name('result');
    });

// Debog
Route::get('/debug', [DebugController::class, 'index'])->name('debug');

// Admin
Route::middleware(['auth', 'verified', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', AdminController::class)->name('index');
    Route::resource('submit', SubmitQuestionController::class)
        ->only(['edit', 'update', 'destroy']);
    Route::resource('notification', NotificationController::class)->except(['edit', 'update'])->parameter('notification', 'message');
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::resource('category', CategoryController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('level', LevelController::class)->only(['index', 'store', 'edit', 'update']);
        Route::get('/stats', StatsController::class)->name('stats');
        Route::resource('images', UploadPublicImagesController::class)->only(['index', 'store', 'destroy']);
    });
    Route::resource('questions', QuestionManagementController::class)->only(['index']);
    Route::get('questions/{question}', [QuestionManagementController::class, 'show'])->withTrashed()->name('questions.show');
});
