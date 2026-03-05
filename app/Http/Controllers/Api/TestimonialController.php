<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestimonialController extends Controller
{
    /**
     * List visible testimonials ordered by sort_order.
     */
    public function index(): AnonymousResourceCollection
    {
        $testimonials = Testimonial::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        return TestimonialResource::collection($testimonials);
    }
}
