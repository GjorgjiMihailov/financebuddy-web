<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $newMessagesCount = ContactMessage::where('status', 'new')->count();
        $totalPostsCount  = Post::count();
        $recentMessages   = ContactMessage::latest()->limit(5)->get();
        $recentPosts      = Post::with('category')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'newMessagesCount',
            'totalPostsCount',
            'recentMessages',
            'recentPosts'
        ));
    }
}
