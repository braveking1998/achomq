<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $question = Question::all()->where('status', 0)->first();
        return Inertia::render('Admin/Index', [
            'question' => $question
        ]);
    }
}
