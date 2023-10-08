<?php

namespace App\Http\Controllers\V1;

use App\Http\Resources\V1\ArticleCollection;
use App\Http\Resources\V1\ArticleResource;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\V1\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ArticleCollection
    {
        return ArticleCollection::make(Article::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $article = Article::query()->create([
            'title' => $request->input('data.attributes.title'),
            'slug' => $request->input('data.attributes.slug'),
            'content' => $request->input('data.attributes.content'),
        ]);

        return ArticleResource::make($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
