<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $translations = $request->user()->translations()->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $translations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'translated_text' => 'required|string', // <-- Change it to this
            'raw_sensor_data' => 'nullable|json',
        ]);

        $translation = $request->user()->translations()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Translation saved successfully',
            'data' => $translation,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
