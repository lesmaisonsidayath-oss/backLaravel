<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PropertySeeder::class,
            FormationSeeder::class,
            BlogPostSeeder::class,
            TestimonialSeeder::class,
            NavigationSeeder::class,
            ContactSettingsSeeder::class,
        ]);
    }
}
