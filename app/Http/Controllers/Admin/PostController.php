<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts      = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $ext  = $request->file('featured_image')->getClientOriginalExtension();
            $name = Str::slug($data['slug'] ?? $data['title']).'-'.time().'.'.$ext;
            $data['featured_image_path'] = $request->file('featured_image')
                ->storeAs('blog/images', $name, 'public');
        }

        if (! empty($data['new_category'])) {
            $cat              = Category::firstOrCreate(
                ['slug' => Str::slug($data['new_category'])],
                ['name' => $data['new_category']]
            );
            $data['category_id'] = $cat->id;
        }

        unset($data['new_category'], $data['featured_image']);

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Постот е успешно зачуван.');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image_path) {
                Storage::disk('public')->delete($post->featured_image_path);
            }
            $ext  = $request->file('featured_image')->getClientOriginalExtension();
            $name = Str::slug($data['slug'] ?? $data['title']).'-'.time().'.'.$ext;
            $data['featured_image_path'] = $request->file('featured_image')
                ->storeAs('blog/images', $name, 'public');
        }

        if (! empty($data['new_category'])) {
            $cat              = Category::firstOrCreate(
                ['slug' => Str::slug($data['new_category'])],
                ['name' => $data['new_category']]
            );
            $data['category_id'] = $cat->id;
        }

        unset($data['new_category'], $data['featured_image']);

        if ($data['status'] === 'published' && ! $post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()->route('admin.posts.edit', $post)
            ->with('success', 'Постот е успешно ажуриран.');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image_path) {
            Storage::disk('public')->delete($post->featured_image_path);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Постот е избришан.');
    }

    public function togglePublish(Post $post)
    {
        if ($post->status === 'published') {
            $post->update(['status' => 'draft']);
            $msg = 'Постот е вратен во нацрт.';
        } else {
            $post->update([
                'status'       => 'published',
                'published_at' => $post->published_at ?? now(),
            ]);
            $msg = 'Постот е објавен.';
        }

        return back()->with('success', $msg);
    }
}
