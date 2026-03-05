<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyController extends Controller
{
    /**
     * List visible properties with optional filters and pagination.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Property::where('is_visible', true)
            ->with('mainImage');

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN));
        }

        $query->latest();

        if ($request->filled('limit')) {
            $query->limit((int) $request->input('limit'));

            return PropertyResource::collection($query->get());
        }

        return PropertyResource::collection($query->paginate(12));
    }

    /**
     * Show a single property by slug with all images.
     */
    public function show(string $slug): PropertyResource
    {
        $property = Property::where('slug', $slug)
            ->with(['images', 'mainImage'])
            ->firstOrFail();

        return new PropertyResource($property);
    }
}
