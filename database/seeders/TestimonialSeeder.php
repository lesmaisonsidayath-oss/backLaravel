<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Aminata Koné',
                'role' => 'Propriétaire',
                'text' => 'Grâce à Les Maisons Idayath, j\'ai trouvé le locataire idéal en moins de 2 semaines. Service professionnel et réactif !',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ibrahim Diallo',
                'role' => 'Acheteur',
                'text' => 'Un accompagnement exceptionnel du début à la fin. L\'équipe a su comprendre mes besoins et me trouver l\'appartement parfait.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'name' => 'Marie-Claire Bamba',
                'role' => 'Investisseur',
                'text' => 'La formation en investissement immobilier m\'a ouvert les yeux. Aujourd\'hui, je gère 3 biens grâce à leurs conseils.',
                'rating' => 5,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }
    }
}
