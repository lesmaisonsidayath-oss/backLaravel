<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case Disponible = 'disponible';
    case Loue = 'loué';
    case Vendu = 'vendu';
    case EnCours = 'en_cours';

    public function label(): string
    {
        return match ($this) {
            self::Disponible => 'Disponible',
            self::Loue => 'Loué',
            self::Vendu => 'Vendu',
            self::EnCours => 'En cours',
        };
    }
}
