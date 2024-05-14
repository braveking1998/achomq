<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Level;
use App\Models\Category;
use App\Models\question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'level', 'text']);

        return Inertia::render('Admin/QuestionManagement/Index', [
            'filters' => $filters,
            'questions' => Question::with('category')->mostRecent()
                ->filter($filters)
                ->userRestrict()
                ->paginate(10)
                ->withQueryString(),
            'categories' => Category::all(),
            'levels' => Level::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(question $question)
    {
        //
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
