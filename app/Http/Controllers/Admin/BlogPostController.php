<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * List all posts (published + drafts), paginated, newest first.
     */
    public function index(): AnonymousResourceCollection
    {
        return BlogPostResource::collection(
            BlogPost::latest('created_at')->paginate(15)
        );
    }

    /**
     * Create a new blog post.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate($this->validationRules());

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blog', 'public');
        }

        // Set published_at when publishing
        if (!empty($validated['is_published']) && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = BlogPost::create($validated);

        return (new BlogPostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show a single blog post.
     */
    public function show(int $id): BlogPostResource
    {
        return new BlogPostResource(BlogPost::findOrFail($id));
    }

    /**
     * Update a blog post.
     */
    public function update(Request $request, int $id): BlogPostResource
    {
        $post = BlogPost::findOrFail($id);

        $validated = $request->validate($this->validationRules(true));

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('blog', 'public');
        }

        // Set published_at when publishing for the first time
        if (!empty($validated['is_published']) && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return new BlogPostResource($post);
    }

    /**
     * Delete a blog post and its image.
     */
    public function destroy(int $id): JsonResponse
    {
        $post = BlogPost::findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json(null, 204);
    }

    /**
     * Get validation rules for store/update.
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        $requiredOrSometimes = $isUpdate ? 'sometimes' : 'required';

        return [
            'title' => [$requiredOrSometimes, 'string', 'max:255'],
            'category' => [$requiredOrSometimes, 'string', 'max:255'],
            'excerpt' => ['sometimes', 'nullable', 'string'],
            'content' => ['sometimes', 'nullable', 'string'],
            'image' => ['sometimes', 'file', 'image', 'max:5120'],
            'read_time' => ['sometimes', 'nullable', 'string', 'max:50'],
            'is_published' => ['sometimes', 'boolean'],
            'published_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
