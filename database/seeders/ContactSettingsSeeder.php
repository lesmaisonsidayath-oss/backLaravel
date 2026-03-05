<?php

namespace Database\Seeders;

use App\Models\ContactSettings;
use Illuminate\Database\Seeder;

class ContactSettingsSeeder extends Seeder
{
    public function run(): void
    {
        ContactSettings::create([
            'phone' => '+225 00 00 000 000',
            'email' => 'contact@maisonsidayath.ci',
            'address' => 'Abidjan, Côte d\'Ivoire',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'whatsapp' => '+225 00 00 000 000',
            'hours_weekday' => 'Lun - Ven : 8h - 18h',
            'hours_weekend' => 'Sam : 9h - 13h',
        ]);
    }
}
