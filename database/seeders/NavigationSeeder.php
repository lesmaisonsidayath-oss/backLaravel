<?php

namespace Database\Seeders;

use App\Models\NavigationItem;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'Accueil', 'href' => '/', 'sort_order' => 1],
            ['label' => 'À Propos', 'href' => '/a-propos', 'sort_order' => 2],
            ['label' => 'Nos Services', 'href' => '/services', 'sort_order' => 3],
            ['label' => 'Biens Immobiliers', 'href' => '/biens', 'sort_order' => 4],
            ['label' => 'Partenaires', 'href' => '/partenaires', 'sort_order' => 5],
            ['label' => 'Contact', 'href' => '/contact', 'sort_order' => 6],
        ];

        foreach ($items as $item) {
            NavigationItem::create($item);
        }

        // Sous-menu pour "Nos Services"
        $services = NavigationItem::where('label', 'Nos Services')->first();
        if ($services) {
            $subItems = [
                ['label' => "Location d'Appartements", 'href' => '/biens?type=location', 'sort_order' => 1],
                ['label' => "Vente d'Appartements", 'href' => '/biens?type=vente&cat=appartement', 'sort_order' => 2],
                ['label' => 'Vente de Terrains', 'href' => '/biens?type=vente&cat=terrain', 'sort_order' => 3],
                ['label' => 'Formations Immobilières', 'href' => '/formations', 'sort_order' => 4],
                ['label' => 'Ameublement & Décoration', 'href' => '/services#decoration', 'sort_order' => 5],
                ['label' => 'Services de Déménagement', 'href' => '/services#demenagement', 'sort_order' => 6],
            ];

            foreach ($subItems as $sub) {
                $sub['parent_id'] = $services->id;
                NavigationItem::create($sub);
            }
        }
    }
}
