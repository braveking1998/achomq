<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LevelController extends Controller
{

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
        $levelPerks = $level->levelPerks()->get()->mapWithKeys(function ($item, $key) {
            return
                [$item->action => (int) $item->value];
        });

        $singleFeatures = $level->singleFeatures()->get()->mapWithKeys(function ($item, $key) {
            return
                [$item->feature => (int) $item->value];
        });

        return Inertia::render('Admin/GameSetting/Level/Edit', [
            'level' => $level,
            'perks' => $levelPerks,
            'features' => $singleFeatures
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
        ]));

        $features = $request->validate([
            'win_coins' => 'required|integer',
            'lose_coins' => 'required|integer',
            'points' => 'required|integer',
            'time' => 'required|integer',
        ]);

        $levelPerks = $request->validate([
            'add_question_points' => 'required|integer',
            'add_question_coins' => 'required|integer',
        ]);

        foreach ($levelPerks as $key => $value) {
            $level->levelPerks()->updateOrCreate(
                ['action' => $key],
                ['value' => $value]
            );
        }

        foreach ($features as $key => $value) {
            $level->singleFeatures()->updateOrCreate(
                ['feature' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'سطح بروزرسانی شد');
    }
}
