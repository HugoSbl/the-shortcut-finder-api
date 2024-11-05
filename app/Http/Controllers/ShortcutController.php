<?php

namespace App\Http\Controllers;

use App\Models\Shortcut;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shortcuts = Shortcut::all();
        return response()->json($shortcuts);
    }

    public function indexByCategory($category_id)
    {
        $shortcuts = Shortcut::where('category_id', $category_id)->get();
        return response()->json($shortcuts);
    }

    public function indexByTags($request)
    {
        $tags = $request->tags;
        $shortcuts = Shortcut::whereHas('tags', function($query) use ($tags) {
            $query->whereIn('tags.id', $tags);
        })->get();
        return response()->json($shortcuts);
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
    public function show(Shortcut $shortcut)
    {
        $shortcut = Shortcut::findOrFail($shortcut->id);
        return response()->json($shortcut);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shortcut $shortcut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shortcut $shortcut)
    {
        //
    }
}
