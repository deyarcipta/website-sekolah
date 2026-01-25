<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kontak', function (Blueprint $table) {
            $table->id();
            $table->text('opening_paragraph')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('map_embed_url')->nullable();
            
            // Staff Contacts
            $table->string('staff1_name')->nullable();
            $table->string('staff1_position')->nullable();
            $table->string('staff1_phone')->nullable();
            $table->string('staff1_email')->nullable();
            $table->string('staff1_image')->nullable();
            
            $table->string('staff2_name')->nullable();
            $table->string('staff2_position')->nullable();
            $table->string('staff2_phone')->nullable();
            $table->string('staff2_email')->nullable();
            $table->string('staff2_image')->nullable();
            
            // Social Media
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            
            // Hero Section
            $table->string('hero_title')->default('Kontak');
            $table->string('hero_background')->nullable();
            
            // Images
            $table->string('contact_image')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kontak');
    }
};