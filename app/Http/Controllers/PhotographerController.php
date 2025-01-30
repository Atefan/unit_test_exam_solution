<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotographerRequest;
use App\Http\Requests\UpdatePhotographerRequest;
use App\Models\Photographer;

class PhotographerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Photographer::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhotographerRequest $request)
    {
        Photographer::create($request->validated());

        return response()->json(Photographer::all(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Photographer $photographer)
    {
        return response()->json($photographer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PhotographerRequest $request, Photographer $photographer)
    {
        $photographer->update($request->validated());

        return response()->json($photographer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photographer $photographer)
    {
        $photographer->delete();

        return response()->json(null, 204);
    }
}
