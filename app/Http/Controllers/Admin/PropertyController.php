<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyImageResource;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * List all properties (including hidden) with filters and pagination.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Property::with('mainImage');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return PropertyResource::collection(
            $query->latest()->paginate(15)
        );
    }

    /**
     * Create a new property.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate($this->validationRules());

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = $request->user()->id;

        $property = Property::create($validated);

        return (new PropertyResource($property))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show a single property with all images.
     */
    public function show(int $id): PropertyResource
    {
        $property = Property::with('images')->findOrFail($id);

        return new PropertyResource($property);
    }

    /**
     * Update a property.
     */
    public function update(Request $request, int $id): PropertyResource
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate($this->validationRules(true));

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $property->update($validated);

        return new PropertyResource($property);
    }

    /**
     * Delete a property and all its images.
     */
    public function destroy(int $id): JsonResponse
    {
        $property = Property::with('images')->findOrFail($id);

        // Delete all image files from storage
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $property->delete();

        return response()->json(null, 204);
    }

    /**
     * Upload multiple images for a property.
     */
    public function uploadImages(Request $request, int $id): JsonResponse
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['required', 'image', 'max:5120'],
        ]);

        $hasMain = $property->images()->where('is_main', true)->exists();
        $uploadedImages = [];

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('properties', 'public');

            $image = $property->images()->create([
                'path' => $path,
                'is_main' => !$hasMain && $index === 0,
                'sort_order' => $property->images()->count(),
            ]);

            $uploadedImages[] = $image;
        }

        return response()->json([
            'images' => PropertyImageResource::collection(collect($uploadedImages)),
        ], 201);
    }

    /**
     * Delete a specific image from a property.
     */
    public function deleteImage(int $id, int $imageId): JsonResponse
    {
        $property = Property::findOrFail($id);
        $image = $property->images()->findOrFail($imageId);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return response()->json(null, 204);
    }

    /**
     * Toggle property visibility.
     */
    public function toggleVisibility(int $id): PropertyResource
    {
        $property = Property::findOrFail($id);
        $property->update(['is_visible' => !$property->is_visible]);

        return new PropertyResource($property);
    }

    /**
     * Toggle property featured status.
     */
    public function toggleFeatured(int $id): PropertyResource
    {
        $property = Property::findOrFail($id);
        $property->update(['is_featured' => !$property->is_featured]);

        return new PropertyResource($property);
    }

    /**
     * Get validation rules for store/update.
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        $requiredOrSometimes = $isUpdate ? 'sometimes' : 'required';

        return [
            'title' => [$requiredOrSometimes, 'string', 'max:255'],
            'type' => [$requiredOrSometimes, 'string', 'in:location,vente'],
            'category' => [$requiredOrSometimes, 'string', 'in:appartement,terrain,studio,F2,F3,F4,villa'],
            'price' => [$requiredOrSometimes, 'integer', 'min:0'],
            'price_label' => [$requiredOrSometimes, 'string', 'max:100'],
            'location' => [$requiredOrSometimes, 'string', 'max:255'],
            'city' => ['sometimes', 'string', 'max:255'],
            'surface' => ['sometimes', 'integer', 'min:0'],
            'rooms' => ['sometimes', 'integer', 'min:0'],
            'bedrooms' => ['sometimes', 'integer', 'min:0'],
            'bathrooms' => ['sometimes', 'integer', 'min:0'],
            'description' => [$requiredOrSometimes, 'string'],
            'features' => ['sometimes', 'array'],
            'is_new' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_visible' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'string', 'in:disponible,loué,vendu,en_cours'],
        ];
    }
}
