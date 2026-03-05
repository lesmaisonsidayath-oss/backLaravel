<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormationResource;
use App\Models\Formation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormationController extends Controller
{
    /**
     * List all formations (including hidden), paginated.
     */
    public function index(): AnonymousResourceCollection
    {
        return FormationResource::collection(
            Formation::latest()->paginate(15)
        );
    }

    /**
     * Create a new formation.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate($this->validationRules());

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('formations', 'public');
        }

        $formation = Formation::create($validated);

        return (new FormationResource($formation))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show a single formation.
     */
    public function show(int $id): FormationResource
    {
        return new FormationResource(Formation::findOrFail($id));
    }

    /**
     * Update a formation.
     */
    public function update(Request $request, int $id): FormationResource
    {
        $formation = Formation::findOrFail($id);

        $validated = $request->validate($this->validationRules(true));

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($formation->image) {
                Storage::disk('public')->delete($formation->image);
            }
            $validated['image'] = $request->file('image')->store('formations', 'public');
        }

        $formation->update($validated);

        return new FormationResource($formation);
    }

    /**
     * Delete a formation and its image.
     */
    public function destroy(int $id): JsonResponse
    {
        $formation = Formation::findOrFail($id);

        if ($formation->image) {
            Storage::disk('public')->delete($formation->image);
        }

        $formation->delete();

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
            'description' => [$requiredOrSometimes, 'string'],
            'duration' => [$requiredOrSometimes, 'string', 'max:255'],
            'format' => [$requiredOrSometimes, 'string', 'in:Présentiel,Distanciel'],
            'level' => [$requiredOrSometimes, 'string', 'in:Débutant,Intermédiaire,Avancé'],
            'price' => [$requiredOrSometimes, 'string', 'max:255'],
            'price_amount' => ['sometimes', 'integer', 'min:0'],
            'next_date' => ['sometimes', 'nullable', 'date'],
            'topics' => ['sometimes', 'array'],
            'image' => ['sometimes', 'file', 'image', 'max:5120'],
            'is_visible' => ['sometimes', 'boolean'],
        ];
    }
}
