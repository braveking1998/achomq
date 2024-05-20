<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Level;
use App\Models\Answer;
use App\Models\Category;
use App\Models\question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'level', 'status', 'text']);

        return Inertia::render('Admin/Questions/Index', [
            'filters' => $filters,
            'questions' => Question::with(['category', 'user'])->withTrashed()
                ->mostRecent()
                ->filter($filters)
                ->paginate(10)
                ->withQueryString(),
            'categories' => Category::all(),
            'levels' => Level::all(),
            'next' => Question::where('status', 1)->first()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(question $question)
    {
        return Inertia::render('Admin/Questions/Show', [
            'question' => $question->load(['answers', 'level', 'category']),
            'prevUrl' => (Str::startsWith(url()->previous(), route('admin.questions.index') . '?page')) ? url()->previous() : route('admin.questions.index')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(question $question)
    {
        return Inertia::render('Admin/Questions/Edit', [
            'question' => $question->load(['answers', 'level', 'category', 'user']),
            'levels' => Level::all(),
            'categories' => Category::all(),
            'prevUrl' => (Str::startsWith(url()->previous(), route('admin.questions.index') . '?page')) ? url()->previous() : route('admin.questions.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, question $question)
    {
        $valid = $request->validate(
            [
                'question' => 'required|string',
                'answers.*' => 'required|distinct',
            ]
        );

        $qUpdate = $question->update([
            'text' => (Str::endsWith($request->question, '؟') ? $request->question : $request->question . '؟'),
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

    public function restore(question $question)
    {
        $question->restore();

        return redirect()->back()->with('success', 'سوال با موفقیت بازگردانی شد.');
    }

    public function suspend(question $question)
    {
        $question->status = 1;
        $question->save();

        return redirect()->back()->with('success', 'سوال با موفقیت معلق شد.');
    }

    public function active(question $question)
    {
        $question->status = 2;
        $question->save();

        return redirect()->back()->with('success', 'سوال با موفقیت تایید شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(question $question)
    {
        if ($question->deleted_at === null) {
            $question->deleteOrFail();

            return redirect()->back()->with('success', 'سوال با موفقیت حذف شد');
        }

        $question->forceDelete();
        return redirect()->back()->with('success', 'سوال با موفقیت حذف شد');
    }
}
