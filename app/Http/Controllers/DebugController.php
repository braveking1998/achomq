<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DebugController extends Controller
{
    public function index(Request $request)
    {
        // $i = 1;
        // while ($i < 16) {
        //     $id = ($i - 1) % 4 == 0 ?? false;
        //     Answer::when(
        //         $id,
        //         fn ($query, $value) => $query->where('id', $i)->update(['is_correct' => true])
        //     );

        //     $i++;
        // }

        // Question::factory()
        //     ->hasAnswers(4, function (array $attributes) {
        //         dd($attributes);
        //     })
        //     ->create();

        // Answer::

        // dd($request->user()->is_admin);
        // return Inertia::render('Debug');
    }
}
