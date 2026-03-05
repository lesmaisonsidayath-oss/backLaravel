<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NavigationItemResource extends JsonResource
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
            'label' => $this->label,
            'href' => $this->href,
            'parent_id' => $this->parent_id,
            'sort_order' => $this->sort_order,
            'is_visible' => $this->is_visible,
            'children' => NavigationItemResource::collection($this->whenLoaded('children')),
        ];
    }
}
