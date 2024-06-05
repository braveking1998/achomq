<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class FrontController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return Inertia::render('FrontPage', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'LaravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'topUsers' => User::where('id', '!=', 1)->orderBy('level_id', 'desc')->orderBy('points', 'desc')->limit(3)->get('name'),
        ]);
    }
}
