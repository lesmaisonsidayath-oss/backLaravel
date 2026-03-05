<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactSettingsResource;
use App\Models\ContactSettings;
use Illuminate\Http\Request;

class ContactSettingsController extends Controller
{
    /**
     * Return the contact settings (first record).
     */
    public function show(): ContactSettingsResource
    {
        $settings = ContactSettings::firstOrFail();

        return new ContactSettingsResource($settings);
    }

    /**
     * Update contact settings (or create if none exist).
     */
    public function update(Request $request): ContactSettingsResource
    {
        $validated = $request->validate([
            'phone' => ['sometimes', 'nullable', 'string', 'max:255'],
            'phone_secondary' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string', 'max:255'],
            'city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'country' => ['sometimes', 'nullable', 'string', 'max:255'],
            'whatsapp' => ['sometimes', 'nullable', 'string', 'max:255'],
            'facebook_url' => ['sometimes', 'nullable', 'string', 'max:255'],
            'instagram_url' => ['sometimes', 'nullable', 'string', 'max:255'],
            'linkedin_url' => ['sometimes', 'nullable', 'string', 'max:255'],
            'tiktok_url' => ['sometimes', 'nullable', 'string', 'max:255'],
            'hours_weekday' => ['sometimes', 'nullable', 'string', 'max:255'],
            'hours_weekend' => ['sometimes', 'nullable', 'string', 'max:255'],
            'google_maps_embed' => ['sometimes', 'nullable', 'string'],
        ]);

        $settings = ContactSettings::first();

        if ($settings) {
            $settings->update($validated);
        } else {
            $settings = ContactSettings::create($validated);
        }

        return new ContactSettingsResource($settings);
    }
}
