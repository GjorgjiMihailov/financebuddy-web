<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Blog/Index', [
            'posts' => Post::published()
                ->with('category')
                ->latest('published_at')
                ->paginate(12)
                ->withQueryString(),
            'categories' => Category::whereHas('publishedPosts')
                ->withCount('publishedPosts')
                ->orderBy('name')
                ->get(),
            'activeCategory' => null,
        ]);
    }

    public function category(Category $category): Response
    {
        return Inertia::render('Blog/Index', [
            'posts' => Post::published()
                ->where('category_id', $category->id)
                ->with('category')
                ->latest('published_at')
                ->paginate(12)
                ->withQueryString(),
            'categories' => Category::whereHas('publishedPosts')
                ->withCount('publishedPosts')
                ->orderBy('name')
                ->get(),
            'activeCategory' => $category->slug,
        ]);
    }

    public function show(Post $post): Response
    {
        abort_if($post->status !== 'published', 404);

        $post->load('category')->append('html_content');

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        return Inertia::render('Blog/Show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
