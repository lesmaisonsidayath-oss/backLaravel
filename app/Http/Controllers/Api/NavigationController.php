<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NavigationItemResource;
use App\Models\NavigationItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NavigationController extends Controller
{
    /**
     * List visible top-level navigation items with visible children.
     */
    public function index(): AnonymousResourceCollection
    {
        $items = NavigationItem::where('is_visible', true)
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->where('is_visible', true)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return NavigationItemResource::collection($items);
    }
}
