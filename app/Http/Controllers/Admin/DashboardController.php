<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Formation;
use App\Models\Property;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Return dashboard statistics.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'total_properties' => Property::count(),
            'properties_by_status' => Property::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
            'total_formations' => Formation::count(),
            'total_blog_posts' => BlogPost::count(),
            'total_testimonials' => Testimonial::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ]);
    }
}
