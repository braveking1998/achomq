<?php

namespace App\Http\Controllers\Api;

use App\Models\question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'level', 'search']);

        return QuestionResource::collection(Question::userRestrict()->filter($filters)->paginate(10)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate(
            [
                'question' => 'required|string',
                'answers.*' => 'required|distinct',
            ]
        );

        $question = $request->user()->questions()->create([
            'unique_id' => (string) Str::orderedUuid(),
            'text' => (Str::endsWith($request->question, '؟') ? $request->question : $request->question . '؟'),
            'level_id' => $request->level,
            'category_id' => $request->category
        ]);

        foreach ($valid['answers'] as $answer) {
            $question->answers()->create([
                'unique_id' => (string) Str::orderedUuid(),
                'text' => $answer,
                'is_correct' => ($answer == $valid['answers']['correct']) ? true : false
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(question $question)
    {
        return new QuestionResource($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(question $question)
    {
        //
    }
}
