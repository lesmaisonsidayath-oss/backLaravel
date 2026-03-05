<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSettings extends Model
{
    use HasFactory;

    const CREATED_AT = null;

    protected $fillable = [
        'phone',
        'phone_secondary',
        'email',
        'address',
        'city',
        'country',
        'whatsapp',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'tiktok_url',
        'hours_weekday',
        'hours_weekend',
        'google_maps_embed',
    ];
}
