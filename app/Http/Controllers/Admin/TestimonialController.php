<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestimonialController extends Controller
{
    /**
     * List all testimonials ordered by sort_order.
     */
    public function index(): AnonymousResourceCollection
    {
        return TestimonialResource::collection(
            Testimonial::orderBy('sort_order')->get()
        );
    }

    /**
     * Create a new testimonial.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate($this->validationRules());

        $testimonial = Testimonial::create($validated);

        return (new TestimonialResource($testimonial))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show a single testimonial.
     */
    public function show(int $id): TestimonialResource
    {
        return new TestimonialResource(Testimonial::findOrFail($id));
    }

    /**
     * Update a testimonial.
     */
    public function update(Request $request, int $id): TestimonialResource
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate($this->validationRules(true));

        $testimonial->update($validated);

        return new TestimonialResource($testimonial);
    }

    /**
     * Delete a testimonial.
     */
    public function destroy(int $id): JsonResponse
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return response()->json(null, 204);
    }

    /**
     * Get validation rules for store/update.
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        $requiredOrSometimes = $isUpdate ? 'sometimes' : 'required';

        return [
            'name' => [$requiredOrSometimes, 'string', 'max:255'],
            'role' => [$requiredOrSometimes, 'string', 'max:255'],
            'text' => [$requiredOrSometimes, 'string'],
            'rating' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'is_visible' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer'],
        ];
    }
}
