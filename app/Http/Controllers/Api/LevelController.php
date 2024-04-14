<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Models\level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LevelResource::collection(Level::all());
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
    public function show(level $level)
    {
        return new LevelResource($level);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, level $level)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(level $level)
    {
        //
    }
}
