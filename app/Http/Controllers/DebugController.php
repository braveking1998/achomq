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
        // $collection = collect(['hi' => 'red', 'hello'])->toObject();

        // return $collection->hi;
    }
}
