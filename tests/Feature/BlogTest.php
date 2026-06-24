<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_shows_only_published_posts(): void
    {
        $category = Category::create(['name' => 'Business', 'slug' => 'business']);

        Post::create([
            'title' => 'Објавен пост',
            'slug' => 'objavен-post',
            'content' => '## Тест содржина',
            'category_id' => $category->id,
            'author_name' => 'FinanceBuddy',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Нацрт пост',
            'slug' => 'nacrt-post',
            'content' => '## Нацрт',
            'author_name' => 'FinanceBuddy',
            'status' => 'draft',
            'published_at' => null,
        ]);

        $this->get(route('blog.index'))
            ->assertStatus(200)
            ->assertInertia(fn ($page) => $page
                ->component('Blog/Index')
                ->has('posts.data', 1)
                ->where('posts.data.0.title', 'Објавен пост')
            );
    }

    public function test_draft_post_returns_404(): void
    {
        Post::create([
            'title' => 'Нацрт пост',
            'slug' => 'nacrt-post',
            'content' => '## Нацрт',
            'author_name' => 'FinanceBuddy',
            'status' => 'draft',
            'published_at' => null,
        ]);

        $this->get(route('blog.show', 'nacrt-post'))
            ->assertStatus(404);
    }

    public function test_published_post_is_accessible(): void
    {
        Post::create([
            'title' => 'Објавен пост',
            'slug' => 'objavен-post',
            'content' => '## Тест содржина',
            'author_name' => 'FinanceBuddy',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('blog.show', 'objavен-post'))
            ->assertStatus(200)
            ->assertInertia(fn ($page) => $page
                ->component('Blog/Show')
                ->has('post.html_content')
                ->has('relatedPosts')
            );
    }

    public function test_category_filter_shows_only_posts_in_category(): void
    {
        $cat1 = Category::create(['name' => 'Business', 'slug' => 'business']);
        $cat2 = Category::create(['name' => 'Marketing', 'slug' => 'marketing']);

        Post::create([
            'title' => 'Business пост',
            'slug' => 'business-post',
            'content' => 'Содржина',
            'category_id' => $cat1->id,
            'author_name' => 'FinanceBuddy',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Marketing пост',
            'slug' => 'marketing-post',
            'content' => 'Содржина',
            'category_id' => $cat2->id,
            'author_name' => 'FinanceBuddy',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('blog.category', 'business'))
            ->assertStatus(200)
            ->assertInertia(fn ($page) => $page
                ->component('Blog/Index')
                ->has('posts.data', 1)
                ->where('posts.data.0.title', 'Business пост')
                ->where('activeCategory', 'business')
            );
    }
}
