<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/GameSetting/Category/Index', [
            'categories' => Category::withCount('questions')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Category::create($request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required',
        ]));

        return redirect()->back()->with('success', 'دسته بندی ایجاد شد');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('Admin/GameSetting/Category/Edit', [
            'category' => $category,
            'previous' => url()->previous(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required',
        ]));

        return redirect()->back()->with('success', 'دسته بندی بروزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $default = Category::where('slug', 'default')->first()->id;
        $category->questions()->where('category_id', $category->id)->update(['category_id' => $default]);
        $category->delete();

        return redirect()->back()->with('success', 'دسته بندی حذف شد');
    }
}
