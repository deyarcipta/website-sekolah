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
        Schema::create('sarpras', function (Blueprint $table) {
            $table->id();
            
            // Hero Section
            $table->string('hero_title')->default('Sarana dan Prasarana');
            $table->string('hero_background')->nullable();
            
            // Opening Paragraph
            $table->text('opening_paragraph')->nullable();
            
            // Lingkungan Belajar Section
            $table->string('learning_title')->default('Lingkungan Belajar Nyaman & Inspiratif');
            $table->text('learning_description')->nullable();
            $table->json('learning_features')->nullable();
            $table->string('learning_image')->nullable();
            
            // Fasilitas Unggulan Section - UPDATE: Menghapus facilities_count
            $table->string('facilities_title')->default('Fasilitas Unggulan');
            $table->json('facilities_items')->nullable();
            
            // Gallery Section - UPDATE: Menghapus gallery_count
            $table->string('gallery_title')->default('Mengintip Fasilitas Kami');
            $table->json('gallery_images')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sarpras');
    }
};