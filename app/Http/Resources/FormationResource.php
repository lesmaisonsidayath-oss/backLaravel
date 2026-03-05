<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
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
            'description' => $this->description,
            'duration' => $this->duration,
            'format' => $this->format,
            'level' => $this->level,
            'price' => $this->price,
            'price_amount' => $this->price_amount,
            'next_date' => $this->next_date,
            'image' => $this->image ? $this->formatImageUrl($this->image) : null,
            'topics' => $this->topics,
            'is_visible' => $this->is_visible,
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
