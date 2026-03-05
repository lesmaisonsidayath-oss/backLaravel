<?php

namespace App\Models;

use App\Enums\PropertyCategory;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'category',
        'price',
        'price_label',
        'location',
        'city',
        'surface',
        'rooms',
        'bedrooms',
        'bathrooms',
        'description',
        'features',
        'is_new',
        'is_featured',
        'is_visible',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'type' => PropertyType::class,
            'category' => PropertyCategory::class,
            'status' => PropertyStatus::class,
            'features' => 'array',
            'is_new' => 'boolean',
            'is_featured' => 'boolean',
            'is_visible' => 'boolean',
            'price' => 'integer',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function mainImage(): HasOne
    {
        return $this->hasOne(PropertyImage::class)->where('is_main', true);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
