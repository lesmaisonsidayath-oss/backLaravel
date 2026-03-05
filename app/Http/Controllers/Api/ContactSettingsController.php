<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactSettingsResource;
use App\Models\ContactSettings;
use Illuminate\Http\JsonResponse;

class ContactSettingsController extends Controller
{
    /**
     * Return the contact settings.
     */
    public function show(): ContactSettingsResource|JsonResponse
    {
        $settings = ContactSettings::first();

        if (! $settings) {
            return response()->json(['message' => 'Contact settings not found.'], 404);
        }

        return new ContactSettingsResource($settings);
    }
}
