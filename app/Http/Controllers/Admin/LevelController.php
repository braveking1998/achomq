<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Level;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/GameSetting/Level/Index', [
            'levels' => Level::withCount('questions')->orderBy('max')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|unique:levels',
            'max' => 'required|integer',
        ]);

        $valid['slug'] = Str::slug($request->slug, '-');

        Level::create($valid);

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
        $valid = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|unique:levels,slug,' . $level->id,
            'max' => 'required|integer',
        ]);

        $valid['slug'] = Str::slug($request->slug, '-');

        $level->update($valid);

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
