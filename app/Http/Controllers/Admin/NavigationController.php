<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\NavigationItemResource;
use App\Models\NavigationItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NavigationController extends Controller
{
    /**
     * List all top-level navigation items with their children, ordered by sort_order.
     */
    public function index(): AnonymousResourceCollection
    {
        $items = NavigationItem::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return NavigationItemResource::collection($items);
    }

    /**
     * Create a new navigation item.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate($this->validationRules());

        $item = NavigationItem::create($validated);

        return (new NavigationItemResource($item))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show a single navigation item.
     */
    public function show(int $id): NavigationItemResource
    {
        $item = NavigationItem::with('children')->findOrFail($id);

        return new NavigationItemResource($item);
    }

    /**
     * Update a navigation item.
     */
    public function update(Request $request, int $id): NavigationItemResource
    {
        $item = NavigationItem::findOrFail($id);

        $validated = $request->validate($this->validationRules(true));

        $item->update($validated);

        return new NavigationItemResource($item->load('children'));
    }

    /**
     * Delete a navigation item (cascade deletes children).
     */
    public function destroy(int $id): JsonResponse
    {
        $item = NavigationItem::findOrFail($id);

        // Delete children first
        $item->children()->delete();
        $item->delete();

        return response()->json(null, 204);
    }

    /**
     * Bulk update sort_order for navigation items.
     */
    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:navigation_items,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            NavigationItem::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['message' => 'Ordre mis à jour.']);
    }

    /**
     * Get validation rules for store/update.
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        $requiredOrSometimes = $isUpdate ? 'sometimes' : 'required';

        return [
            'label' => [$requiredOrSometimes, 'string', 'max:255'],
            'href' => [$requiredOrSometimes, 'string', 'max:255'],
            'parent_id' => ['sometimes', 'nullable', 'integer', 'exists:navigation_items,id'],
            'sort_order' => ['sometimes', 'integer'],
            'is_visible' => ['sometimes', 'boolean'],
        ];
    }
}
