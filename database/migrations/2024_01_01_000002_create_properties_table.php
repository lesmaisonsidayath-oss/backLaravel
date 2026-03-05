<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->enum('type', ['location', 'vente']);
            $table->enum('category', ['appartement', 'terrain', 'studio', 'F2', 'F3', 'F4', 'villa']);
            $table->bigInteger('price')->unsigned();
            $table->string('price_label', 100);
            $table->string('location', 255);
            $table->string('city', 255)->default('Abidjan');
            $table->unsignedInteger('surface')->default(0);
            $table->unsignedInteger('rooms')->default(0);
            $table->unsignedInteger('bedrooms')->default(0);
            $table->unsignedInteger('bathrooms')->default(0);
            $table->text('description');
            $table->json('features')->nullable();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->enum('status', ['disponible', 'loué', 'vendu', 'en_cours'])->default('disponible');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
