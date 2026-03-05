<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        $formations = [
            [
                'title' => "Les Fondamentaux de l'Investissement Immobilier",
                'description' => "Apprenez les bases de l'investissement immobilier : analyse de marché, financement, rentabilité et fiscalité.",
                'duration' => '3 jours (21h)',
                'format' => 'Présentiel',
                'level' => 'Débutant',
                'price' => '150 000 FCFA',
                'price_amount' => 150000,
                'next_date' => '15 Mars 2026',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800',
                'topics' => ['Analyse de marché', 'Financement immobilier', 'Calcul de rentabilité', 'Fiscalité immobilière'],
            ],
            [
                'title' => 'Gestion Locative Professionnelle',
                'description' => 'Maîtrisez la gestion locative : sélection des locataires, baux, contentieux et optimisation des revenus.',
                'duration' => '2 jours (14h)',
                'format' => 'Présentiel',
                'level' => 'Intermédiaire',
                'price' => '120 000 FCFA',
                'price_amount' => 120000,
                'next_date' => '22 Mars 2026',
                'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=800',
                'topics' => ['Rédaction de bail', 'Sélection de locataires', 'Gestion des impayés', 'Optimisation fiscale'],
            ],
            [
                'title' => 'Négociation et Transaction Immobilière',
                'description' => "Techniques avancées de négociation, prospection et closing dans l'immobilier.",
                'duration' => '2 jours (14h)',
                'format' => 'Distanciel',
                'level' => 'Avancé',
                'price' => '180 000 FCFA',
                'price_amount' => 180000,
                'next_date' => '5 Avril 2026',
                'image' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=800',
                'topics' => ['Techniques de prospection', 'Art de la négociation', 'Closing efficace', 'Relation client'],
            ],
        ];

        foreach ($formations as $data) {
            $data['slug'] = Str::slug($data['title']);
            Formation::create($data);
        }
    }
}
