<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LevelController extends Controller
{
    private function feature($level, $feature)
    {
        $feature = $level->singleFeatures()->where('feature', $feature)->first();

        if ($feature) {
            return $feature->value;
        }

        return false;
    }

    public function index()
    {
        return Inertia::render('Admin/GameSetting/Level/Index', [
            'levels' => Level::withCount('questions')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required',
            'max' => 'required|integer',
        ]);
        Level::create($validate);

        return redirect()->back()->with('success', 'سطح ایجاد شد.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        return Inertia::render('Admin/GameSetting/Level/Edit', [
            'level' => $level,
            'win_coins' => (int) $this->feature($level, 'win_coins') ?? false,
            'lose_coins' => (int) $this->feature($level, 'lose_coins') ?? false,
            'points' => (int) $this->feature($level, 'points') ?? false,
            'time' => (int) $this->feature($level, 'time') ?? false,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        $level->update($request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required',
            'max' => 'required|integer',
            'add_question' => 'required|integer',
        ]));

        $features = $request->validate([
            'win_coins' => 'required|integer',
            'lose_coins' => 'required|integer',
            'points' => 'required|integer',
            'time' => 'required|integer',
        ]);

        foreach ($features as $key => $value) {
            $level->singlePlayer()->updateOrCreate(
                ['feature' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'سطح بروزرسانی شد');
    }
}
