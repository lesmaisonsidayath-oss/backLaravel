<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'title' => 'Magnifique Appartement F3 Vue Mer',
                'type' => 'vente',
                'category' => 'F3',
                'price' => 45000000,
                'price_label' => '45 000 000 FCFA',
                'location' => 'Plateau, Quartier Résidentiel',
                'city' => 'Abidjan',
                'surface' => 95,
                'rooms' => 4,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'description' => 'Superbe appartement F3 avec vue dégagée, finitions haut de gamme, cuisine équipée et parking sécurisé.',
                'features' => ['Parking', 'Ascenseur', 'Balcon', 'Climatisation', 'Cuisine équipée'],
                'is_new' => true,
                'is_featured' => true,
                'status' => 'disponible',
            ],
            [
                'title' => 'Studio Moderne Centre-Ville',
                'type' => 'location',
                'category' => 'studio',
                'price' => 150000,
                'price_label' => '150 000 FCFA/mois',
                'location' => 'Cocody, Riviera',
                'city' => 'Abidjan',
                'surface' => 35,
                'rooms' => 1,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'description' => 'Studio entièrement rénové et meublé, idéal pour jeune professionnel. Proche de toutes commodités.',
                'features' => ['Meublé', 'Climatisation', 'Internet', 'Gardiennage'],
                'is_new' => false,
                'is_featured' => true,
                'status' => 'disponible',
            ],
            [
                'title' => 'Villa Luxueuse avec Piscine',
                'type' => 'vente',
                'category' => 'villa',
                'price' => 120000000,
                'price_label' => '120 000 000 FCFA',
                'location' => 'Riviera Golf',
                'city' => 'Abidjan',
                'surface' => 350,
                'rooms' => 8,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'description' => 'Magnifique villa de standing avec piscine, jardin paysager et dépendances. Construction récente.',
                'features' => ['Piscine', 'Jardin', 'Garage', 'Gardiennage 24h', 'Groupe électrogène'],
                'is_new' => true,
                'is_featured' => true,
                'status' => 'disponible',
            ],
            [
                'title' => 'Appartement F2 Rénové',
                'type' => 'location',
                'category' => 'F2',
                'price' => 200000,
                'price_label' => '200 000 FCFA/mois',
                'location' => 'Marcory, Zone 4',
                'city' => 'Abidjan',
                'surface' => 55,
                'rooms' => 3,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'description' => 'Bel appartement F2 entièrement rénové dans un quartier calme et sécurisé.',
                'features' => ['Balcon', 'Parking', 'Climatisation'],
                'is_new' => false,
                'is_featured' => true,
                'status' => 'disponible',
            ],
            [
                'title' => 'Terrain Constructible 500m²',
                'type' => 'vente',
                'category' => 'terrain',
                'price' => 25000000,
                'price_label' => '25 000 000 FCFA',
                'location' => 'Bingerville',
                'city' => 'Abidjan',
                'surface' => 500,
                'rooms' => 0,
                'bedrooms' => 0,
                'bathrooms' => 0,
                'description' => 'Terrain viabilisé dans un lotissement sécurisé. ACD et permis de construire disponibles.',
                'features' => ['Viabilisé', 'Clôturé', 'ACD disponible'],
                'is_new' => true,
                'is_featured' => false,
                'status' => 'disponible',
            ],
            [
                'title' => 'Grand Appartement F4 Familial',
                'type' => 'vente',
                'category' => 'F4',
                'price' => 65000000,
                'price_label' => '65 000 000 FCFA',
                'location' => 'Cocody Angré',
                'city' => 'Abidjan',
                'surface' => 130,
                'rooms' => 5,
                'bedrooms' => 4,
                'bathrooms' => 2,
                'description' => 'Spacieux F4 dans une résidence calme, parfait pour une famille. Grand salon, cuisine aménagée.',
                'features' => ['Parking', 'Balcon', 'Ascenseur', 'Gardiennage', 'Climatisation'],
                'is_new' => false,
                'is_featured' => true,
                'status' => 'disponible',
            ],
        ];

        foreach ($properties as $data) {
            $data['slug'] = Str::slug($data['title']);
            Property::create($data);
        }
    }
}
