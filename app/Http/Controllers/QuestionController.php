<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Level;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Question::class, 'question');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'level', 'text']);

        return Inertia::render(
            'Questions/Index',
            [
                'filters' => $filters,
                'questions' => Question::with('category')->mostRecent()
                    ->filter($filters)
                    ->userRestrict()
                    ->paginate(10)
                    ->withQueryString(),
                'categories' => Category::all(),
                'levels' => Level::all(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Questions/Create', [
            'levels' => Level::all(),
            'categories' => Category::all(),
        ]);
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
            'text' => (Str::endsWith($request->question, '؟') ? $request->question : $request->question.'؟'),
            'level_id' => $request->level_id,
            'category_id' => $request->category_id,
        ]);

        foreach ($valid['answers'] as $answer) {
            $question->answers()->create([
                'unique_id' => (string) Str::orderedUuid(),
                'text' => $answer,
                'is_correct' => ($answer == $valid['answers']['correct']) ? true : false,
            ]);
        }

        return redirect()->back()->with('success', 'سوال با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return Inertia::render('Questions/Show', [
            'question' => $question->load(['answers', 'level', 'category']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        // dd($question);
        return Inertia::render('Questions/Edit', [
            'question' => $question::with(['answers', 'level', 'category', 'user'])->find($question->id),
            'levels' => Level::all(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $valid = $request->validate(
            [
                'question' => 'required|string',
                'answers.*' => 'required|distinct',
            ]
        );

        $qUpdate = $question->update([
            'text' => (Str::endsWith($request->question, '؟') ? $request->question : $request->question.'؟'),
            'level_id' => $request->level_id,
            'category_id' => $request->category_id,
        ]);

        // Update answers
        $answers = Answer::where('question_id', $question->id)->get();

        $newAnswers = [];
        foreach ($valid['answers'] as $answer) {
            $newAnswers[] = $answer;
        }

        $i = 0;
        foreach ($answers as $answer) {
            $answer->text = $newAnswers[$i];
            $answer->save();

            $i++;
        }

        return redirect()->back()->with('success', 'سوال با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->deleteOrFail();

        return redirect()->route('questions.index')->with('success', 'سوال با موفقیت حذف شد');
    }
}
