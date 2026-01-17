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
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_name')->nullable();
            $table->text('description');
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            
            // Section 1: Overview
            $table->text('overview_title')->nullable();
            $table->text('overview_content')->nullable();
            $table->string('overview_image')->nullable();
            
            // Section 2: Vision & Mission
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision_mission_title')->nullable();
            $table->text('vision_mission_content')->nullable();
            $table->string('vision_mission_image')->nullable();
            $table->text('quote')->nullable();
            $table->string('quote_author')->nullable();
            $table->string('quote_position')->nullable();
            
            // Section 3: Learning
            $table->text('learning_title')->nullable();
            $table->text('learning_content')->nullable();
            $table->json('learning_items')->nullable();
            $table->string('learning_image')->nullable();
            
            // Section 4: Teachers
            $table->text('teachers_title')->nullable();
            $table->text('teachers_content')->nullable();
            
            // Section 5: Achievements
            $table->text('achievements_title')->nullable();
            $table->text('achievements_content')->nullable();
            $table->json('achievement_items')->nullable();
            
            // Section 6: Accordion (Program Details)
            $table->json('accordion_items')->nullable();
            $table->string('accordion_image')->nullable();
            
            // Seo
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('major_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('position');
            $table->string('image')->nullable();
            $table->text('bio')->nullable();
            $table->string('education')->nullable();
            $table->string('expertise')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        Schema::create('major_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('image')->nullable();
            $table->integer('year');
            $table->string('level')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('major_achievements');
        Schema::dropIfExists('major_teachers');
        Schema::dropIfExists('majors');
    }
};