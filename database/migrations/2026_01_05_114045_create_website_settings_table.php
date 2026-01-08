<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            
            // Site Basic Info
            $table->string('site_name')->default('SMK Wisata Indonesia');
            $table->string('site_tagline')->nullable();
            $table->text('site_description')->nullable(); // TEXT - NO DEFAULT
            $table->string('site_logo')->nullable()->default('assets/img/logo-wistek.png');
            $table->string('site_favicon')->nullable();
            $table->string('site_email')->nullable()->default('info@smkwisataindonesia.sch.id');
            $table->string('site_phone')->nullable()->default('(021) 12345678');
            $table->string('site_whatsapp')->nullable();
            $table->text('site_address')->nullable(); // TEXT - NO DEFAULT
            
            // Social Media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable(); // TEXT - NO DEFAULT
            $table->text('meta_keywords')->nullable(); // TEXT - NO DEFAULT
            $table->string('google_analytics')->nullable();
            
            // System
            $table->string('timezone')->default('Asia/Jakarta');
            $table->string('date_format')->default('d/m/Y');
            $table->string('time_format')->default('H:i');
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable(); // TEXT - NO DEFAULT
            
            // Contact Info
            $table->string('headmaster_name')->nullable();
            $table->string('headmaster_nip')->nullable();
            $table->string('headmaster_photo')->nullable();
            $table->text('headmaster_message')->nullable(); // TEXT - NO DEFAULT
            
            // School Identity
            $table->string('school_npsn')->nullable()->default('12345678');
            $table->string('school_nss')->nullable();
            $table->string('school_akreditation')->nullable()->default('A');
            $table->string('school_operator_name')->nullable();
            $table->string('school_operator_email')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('website_settings');
    }
};