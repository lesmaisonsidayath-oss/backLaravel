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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();
            $table->string('duration', 100)->nullable();
            $table->enum('format', ['Présentiel', 'Distanciel'])->nullable();
            $table->enum('level', ['Débutant', 'Intermédiaire', 'Avancé'])->nullable();
            $table->string('price', 100)->nullable();
            $table->bigInteger('price_amount')->unsigned()->nullable();
            $table->string('next_date', 100)->nullable();
            $table->string('image', 500)->nullable();
            $table->json('topics')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
