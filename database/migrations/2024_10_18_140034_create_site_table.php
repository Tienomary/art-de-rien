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
        Schema::create('site', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->json('titre')->nullable();
            $table->json('a_propos_de_moi_titre')->nullable();
            $table->json('a_propos_de_moi_description')->nullable();
            $table->json('a_propos_de_moi_description_modal')->nullable();
            $table->json('a_propos_de_moi_button')->nullable();
            $table->json('mes_competences_titre')->nullable();
            $table->json('mes_competences_description')->nullable();
            $table->json('mes_competences_one_titre')->nullable();
            $table->json('mes_competences_one_description')->nullable();
            $table->json('mes_competences_two_titre')->nullable();
            $table->json('mes_competences_two_description')->nullable();
            $table->json('mes_competences_three_titre')->nullable();
            $table->json('mes_competences_three_description')->nullable();
            $table->json('mes_creations_titre')->nullable();
            $table->json('contact_titre')->nullable();
            $table->json('contact_description')->nullable();
            $table->json('phone')->nullable();
            $table->json('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site');
    }
};
