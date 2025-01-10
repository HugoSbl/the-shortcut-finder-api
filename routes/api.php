<?php

use App\Http\Controllers\ShortcutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [AuthController::class, 'registerGoogle']);
    Route::get('/auth/facebook/callback', [AuthController::class, 'registerFacebook']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
});

Route::controller(ShortcutController::class)->group(function () {
    Route::get('/shortcuts', [ShortcutController::class, 'index']);
    Route::get('/shortcuts/{category}', [ShortcutController::class, 'indexByCategory']);
    Route::get('/shortcut/{shortcut_id}', [ShortcutController::class, 'show']);
    Route::get('/shortcuts/{tags_ids}', [ShortcutController::class, 'indexByTags']);
    Route::get('/shortcuts/{user_id}', [ShortcutController::class, 'indexByUser']);
    Route::get('/shortcuts/{app_id}', [ShortcutController::class, 'indexByApp']);
    Route::get('/shortcuts/download/{shortcut_id}', [ShortcutController::class, 'download']);
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
