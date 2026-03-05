<?php

namespace App\Enums;

enum PropertyType: string
{
    case Location = 'location';
    case Vente = 'vente';

    public function label(): string
    {
        return match ($this) {
            self::Location => 'Location',
            self::Vente => 'Vente',
        };
    }
}
