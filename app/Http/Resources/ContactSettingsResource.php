<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactSettingsResource extends JsonResource
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
            'phone' => $this->phone,
            'phone_secondary' => $this->phone_secondary,
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'whatsapp' => $this->whatsapp,
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'tiktok_url' => $this->tiktok_url,
            'hours_weekday' => $this->hours_weekday,
            'hours_weekend' => $this->hours_weekend,
            'google_maps_embed' => $this->google_maps_embed,
            'updated_at' => $this->updated_at,
        ];
    }
}
