<?php

namespace App\Livewire\Admin;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BlogPostsIndex extends Component
{
    public function delete(int $id): void
    {
        BlogPost::findOrFail($id)->delete();
        Cache::forget('homepage.posts');
        session()->flash('status', 'Blog post deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.blog-posts-index', [
            'posts' => BlogPost::latest()->get(),
        ])->layout('components.layouts.admin', ['title' => 'Blog Posts']);
    }
}
