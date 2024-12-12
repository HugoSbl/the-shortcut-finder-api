<?php

use App\Http\Controllers\ShortcutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ShortcutController::class)->group(function () {
    Route::get('/shortcuts', [ShortcutController::class, 'index']);
    Route::get('/shortcuts/{category}', [ShortcutController::class, 'indexByCategory']);
    Route::get('/shortcuts/{shortcut_id}', [ShortcutController::class, 'show']);
    Route::post('/shortcuts', [ShortcutController::class, 'store']);
    Route::put('/shortcuts/{shortcut_id}', [ShortcutController::class, 'update']);
    Route::delete('/shortcuts/{shortcut_id}', [ShortcutController::class, 'destroy']);
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category_id}', [CategoryController::class, 'show']);
    Route::put('/categories/{category_id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category_id}', [CategoryController::class, 'destroy']);
});

Route::controller(TagController::class)->group(function () {
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::get('/tags/{tag_id}', [TagController::class, 'show']);
    Route::put('/tags/{tag_id}', [TagController::class, 'update']);
    Route::delete('/tags/{tag_id}', [TagController::class, 'destroy']);
});

Route::fallback(function(){
    return response()->json(['message' => 'Ressource introuvable.'], 404);
});
