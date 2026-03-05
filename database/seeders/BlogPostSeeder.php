<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => '5 Conseils pour Réussir son Premier Investissement Immobilier',
                'excerpt' => "L'investissement immobilier peut sembler intimidant. Voici nos 5 conseils essentiels pour démarrer sereinement.",
                'content' => "<p>L'investissement immobilier peut sembler intimidant pour les débutants. Voici nos 5 conseils essentiels pour démarrer sereinement.</p>",
                'category' => 'Investissement',
                'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800',
                'read_time' => '5 min',
                'is_published' => true,
                'published_at' => '2026-02-12',
            ],
            [
                'title' => 'Les Tendances du Marché Immobilier en 2026',
                'excerpt' => 'Découvrez les grandes tendances qui façonnent le marché immobilier cette année et comment en tirer profit.',
                'content' => '<p>Découvrez les grandes tendances qui façonnent le marché immobilier cette année.</p>',
                'category' => 'Marché',
                'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800',
                'read_time' => '7 min',
                'is_published' => true,
                'published_at' => '2026-02-08',
            ],
            [
                'title' => 'Guide Complet : Comment Bien Préparer son Déménagement',
                'excerpt' => 'Un déménagement réussi se prépare. Suivez notre guide étape par étape pour une transition en douceur.',
                'content' => '<p>Un déménagement réussi se prépare. Suivez notre guide étape par étape.</p>',
                'category' => 'Conseils',
                'image' => 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=800',
                'read_time' => '6 min',
                'is_published' => true,
                'published_at' => '2026-02-01',
            ],
            [
                'title' => 'Décoration Intérieure : Les Erreurs à Éviter',
                'excerpt' => "Évitez les pièges courants de la décoration et transformez votre intérieur avec nos conseils d'experts.",
                'content' => "<p>Évitez les pièges courants de la décoration et transformez votre intérieur.</p>",
                'category' => 'Décoration',
                'image' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800',
                'read_time' => '4 min',
                'is_published' => true,
                'published_at' => '2026-01-25',
            ],
        ];

        foreach ($posts as $data) {
            $data['slug'] = Str::slug($data['title']);
            BlogPost::create($data);
        }
    }
}
