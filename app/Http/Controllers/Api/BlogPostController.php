<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogPostController extends Controller
{
    /**
     * List published blog posts ordered by published_at descending.
     */
    public function index(): AnonymousResourceCollection
    {
        $posts = BlogPost::where('is_published', true)
            ->with('creator')
            ->orderByDesc('published_at')
            ->get();

        return BlogPostResource::collection($posts);
    }

    /**
     * Show a single published blog post by slug.
     */
    public function show(string $slug): BlogPostResource
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->with('creator')
            ->firstOrFail();

        return new BlogPostResource($post);
    }
}
