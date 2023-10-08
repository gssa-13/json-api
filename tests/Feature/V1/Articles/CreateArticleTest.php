<?php

namespace Tests\Feature\V1\Articles;

use App\Models\V1\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_articles(): void
    {
        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'New article',
                    'slug' => 'new-slug',
                    'content' => 'Article content'
                ]
            ]
        ]);

        $response->assertCreated();

        $article = Article::query()->first();

        $response->assertHeader(
            'Location',
            route('api.v1.articles.show', $article)
        );

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => 'New article',
                    'slug' => 'new-slug',
                    'content' => 'Article content'
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]
            ]
        ]);
    }

    /** @test */
    public function title_is_required(): void
    {
        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'slug' => 'new-slug',
                    'content' => 'Article content'
                ]
            ]
        ]);

        $response->assertJsonValidationErrorFor('data.attributes.title');
    }

    /** @test */
    public function title_must_be_at_least_10_characters(): void
    {
        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'New',
                    'slug' => 'new-slug',
                    'content' => 'Article content'
                ]
            ]
        ]);

        $response->assertJsonValidationErrorFor('data.attributes.title');
    }

    /** @test */
    public function slug_is_required(): void
    {
        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'New article',
                    'content' => 'Article content'
                ]
            ]
        ]);

        $response->assertJsonValidationErrorFor('data.attributes.slug');
    }

    /** @test */
    public function content_is_required(): void
    {
        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'New article',
                    'slug' => 'new-slug',
                ]
            ]
        ]);

        $response->assertJsonValidationErrorFor('data.attributes.content');
    }
}
