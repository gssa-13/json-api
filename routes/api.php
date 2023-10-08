<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\ArticleController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('articles', [ArticleController::class, 'index'])
    ->name('api.v1.articles.index');

Route::get('articles/{article}', [ArticleController::class, 'show'])
    ->name('api.v1.articles.show');

Route::post('articles', [ArticleController::class, 'store'])
    ->name('api.v1.articles.store');
