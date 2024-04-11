<?php

namespace App\Http\Controllers\Admin;

use App\Events\AddQuestion;
use Inertia\Inertia;
use App\Models\Level;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmitQuestionController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $next = Question::all()->where('status', 0)->where('id', '!=', $id)->first();

        return Inertia::render('Admin/Submit', [
            'question' => Question::with(['answers', 'level', 'category', 'user'])->find($id),
            'next' => $next,
            'levels' => Level::all(),
            'categories' => Category::all()
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
            'status' => 1
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
    public function destroy(string $id)
    {
        $question = Question::find($id);
        $question->deleteOrFail();
        return redirect()->back()->with('success', 'سوال با موفقیت حذف شد');
    }
}
