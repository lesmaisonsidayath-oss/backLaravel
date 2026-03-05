<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormationResource;
use App\Models\Formation;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FormationController extends Controller
{
    /**
     * List visible formations ordered by next_date.
     */
    public function index(): AnonymousResourceCollection
    {
        $formations = Formation::where('is_visible', true)
            ->orderBy('next_date')
            ->get();

        return FormationResource::collection($formations);
    }

    /**
     * Show a single formation by slug.
     */
    public function show(string $slug): FormationResource
    {
        $formation = Formation::where('slug', $slug)->firstOrFail();

        return new FormationResource($formation);
    }
}
