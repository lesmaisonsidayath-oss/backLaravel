<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'category' => $this->category,
            'price' => $this->price,
            'price_label' => $this->price_label,
            'location' => $this->location,
            'city' => $this->city,
            'surface' => $this->surface,
            'rooms' => $this->rooms,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'description' => $this->description,
            'features' => $this->features,
            'is_new' => $this->is_new,
            'is_featured' => $this->is_featured,
            'is_visible' => $this->is_visible,
            'status' => $this->status,
            'image' => $this->whenLoaded('mainImage', function () {
                $image = $this->mainImage;
                if (! $image) {
                    $image = $this->whenLoaded('images', fn () => $this->images->first());
                }

                return $image ? $this->formatImageUrl($image->path) : null;
            }),
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(fn ($image) => $this->formatImageUrl($image->path))->toArray();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Format an image URL: return as-is if it starts with http, otherwise prepend storage URL.
     */
    protected function formatImageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return asset('storage/' . $path);
    }
}
