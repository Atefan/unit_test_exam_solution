<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Photographer;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Photographer $photographer)
    {
        return response()->json($photographer->albums);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Photographer $photographer, AlbumRequest $request)
    {
        $photographer->albums()->create($request->validated());

        return response()->json($photographer->albums, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Photographer $photographer, Album $album)
    {
        return response()->json($album);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Photographer $photographer, AlbumRequest $request, Album $album)
    {
        $album->update($request->validated());

        return response()->json($album);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photographer $photographer, Album $album)
    {
        $album->delete();

        return response()->json(null, 204);
    }
}
