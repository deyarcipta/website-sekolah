<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visi_misi', function (Blueprint $table) {
            $table->id();
            
            // Hero Section
            $table->string('hero_title')->default('Visi & Misi');
            $table->string('hero_background')->nullable();
            
            // Opening Paragraph
            $table->text('opening_paragraph');
            
            // 3 Cards
            $table->string('card1_image')->nullable();
            $table->string('card1_label')->default('Kreatif');
            $table->string('card2_image')->nullable();
            $table->string('card2_label')->default('Unggul');
            $table->string('card3_image')->nullable();
            $table->string('card3_label')->default('Berakhlak Mulia');
            
            // Visi
            $table->string('visi_image')->nullable();
            $table->string('visi_title')->default('Visi Kami');
            $table->text('visi_description');
            $table->json('visi_items')->nullable();
            
            // Misi
            $table->string('misi_image')->nullable();
            $table->string('misi_title')->default('Misi Kami');
            $table->text('misi_description');
            $table->json('misi_items')->nullable();
            
            // Timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visi_misi');
    }
};