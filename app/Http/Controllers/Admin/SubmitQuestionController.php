<?php

namespace App\Http\Controllers\Admin;

use App\Events\AddQuestion;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Level;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SubmitQuestionController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        if ($question->status === 2) {
            abort(404);
        }
        $next = Question::all()->where('status', 1)->where('id', '>', $question->id)->first();

        return Inertia::render('Admin/Questions/Submit', [
            'question' => $question->load(['answers', 'level', 'category', 'user']),
            'next' => $next,
            'levels' => Level::all(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $valid = $request->validate(
            [
                'question' => 'required|string',
                'answers.*' => 'required|distinct',
            ]
        );

        $question = Question::find($id);

        $qUpdate = $question->update([
            'text' => (Str::endsWith($request->question, '؟') ? $request->question : $request->question . '؟'),
            'level_id' => $request->level_id,
            'category_id' => $request->category_id,
            'status' => 2,
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

        // If approved
        AddQuestion::dispatch($question->user);

        return redirect()->back()->with('success', 'سوال با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->deleteOrFail();
        $next = Question::all()->where('status', 1)->where('id', '>', $question->id)->first();

        if ($next !== null) {
            return redirect()->route('admin.questions.submit.edit', ['question' => $next])->with('success', 'سوال با موفقیت حذف شد');
        }

        return redirect()->route('admin.questions.index')->with('success', 'سوال با موفقیت حذف شد.');
    }
}
