<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'duration',
        'format',
        'level',
        'price',
        'price_amount',
        'next_date',
        'image',
        'topics',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'topics' => 'array',
            'is_visible' => 'boolean',
            'price_amount' => 'integer',
        ];
    }
}
