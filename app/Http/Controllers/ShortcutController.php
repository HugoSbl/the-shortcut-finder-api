<?php

namespace App\Http\Controllers;

use App\Models\Shortcut;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ShortcutStorage;

class ShortcutController extends Controller
{
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

    public function indexByUser($user_id)
    {
        $shortcuts = Shortcut::where('user_id', $user_id)->get();
        return response()->json($shortcuts);
    }

    public function indexByApp($app_id)
    {
        $shortcuts = Shortcut::where('app_id', $app_id)->get();
        return response()->json($shortcuts);
    }

    public function download($shortcut_id)
    {
        $shortcut = Shortcut::findOrFail($shortcut_id);
        $shortcut->number_of_downloads += 1;
        $shortcut_storage = ShortcutStorage::where('shortcut_id', $shortcut_id)->first();
        $shortcut->save();
        if($shortcut_storage->storage_type == 'icloud') {
            return response()->json(['icloud' => $shortcut_storage->storage_url]);
        } else if ($shortcut_storage->storage_type == 'file') {
            return response()->json(['link' => $shortcut_storage->storage_url]);
        } else
        {   
            return response()->json(['error' => 'No download link available.']);
        }
        
    }

    public function store(Request $request)
    {
       $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'complete_description' => 'required',
            'category_id' => 'required',
        ]);
        $shortcut = Shortcut::create($request->all());
        if($request->has('tags')) {

            $shortcut->tags()->attach($request->tags);
        }
        if($request->has('app_id')) {
            $shortcut->app()->associate($request->app_id);
        }
        if($request->has('images')) {
            $request->images->store('images/shortcuts/'.$shortcut->id, 'public'); //enregistrement des images
            $shortcut->user()->associate($request->user_id);
        }

        //$currentUser = auth()->user();
        //$shortcut->user()->associate($currentUser);
        return response()->json($shortcut);
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
        $request = $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'complete_description' => 'required',
            'new_version_update' => 'required',
            'link_to_shortcut' => 'required',
            'category_id' => 'required',
        ], 
        [
            'title.required' => 'The title of the shortcut is required.',
            'short_description.required' => 'The short description is required.',
            'complete_description.required' => 'The complete description is required.',
            'new_version_update.required' => 'You need to complete the version note in order to update the shortcut. PLease indicate what changes you have made to the shortcut.',
            'category_id.required' => 'Category of shortcut is required.',
        ]);
        $current_user = auth()->user();
        $shortcut_to_update = Shortcut::findOrFail($shortcut->id);
        if ($current_user->id != $shortcut_to_update->user_id) {
            return response()->json(['error' => 'You are not allowed to update this shortcut.'], 403);
        }
        $shortcut->update($request);
        return response()->json($shortcut);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shortcut $shortcut)
    {
        //
    }
}
