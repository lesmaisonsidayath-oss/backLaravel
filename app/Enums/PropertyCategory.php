<?php

namespace App\Enums;

enum PropertyCategory: string
{
    case Appartement = 'appartement';
    case Terrain = 'terrain';
    case Studio = 'studio';
    case F2 = 'F2';
    case F3 = 'F3';
    case F4 = 'F4';
    case Villa = 'villa';

    public function label(): string
    {
        return match ($this) {
            self::Appartement => 'Appartement',
            self::Terrain => 'Terrain',
            self::Studio => 'Studio',
            self::F2 => 'F2',
            self::F3 => 'F3',
            self::F4 => 'F4',
            self::Villa => 'Villa',
        };
    }
}
