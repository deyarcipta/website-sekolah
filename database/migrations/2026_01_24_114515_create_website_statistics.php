<?php
// database/migrations/xxxx_xx_xx_create_website_statistics_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('website_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Nama statistik (contoh: pageview_hari_ini)');
            $table->string('display_name')->comment('Nama tampilan (contoh: Pageview Hari Ini)');
            $table->string('category')->default('general')->comment('Kategori statistik');
            $table->bigInteger('value')->default(0)->comment('Nilai statistik');
            $table->string('unit')->nullable()->comment('Satuan (contoh: views, visitors)');
            $table->string('icon')->nullable()->comment('Icon untuk tampilan');
            $table->string('color')->nullable()->comment('Warna untuk tampilan');
            $table->integer('sort_order')->default(0)->comment('Urutan tampilan');
            $table->boolean('is_visible')->default(true)->comment('Apakah ditampilkan di frontend');
            $table->boolean('is_editable')->default(true)->comment('Apakah bisa diubah manual');
            $table->boolean('is_auto_increment')->default(false)->comment('Apakah otomatis bertambah');
            $table->json('settings')->nullable()->comment('Pengaturan tambahan');
            $table->text('description')->nullable()->comment('Deskripsi statistik');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_statistic_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statistic_id')->constrained('website_statistics')->onDelete('cascade');
            $table->bigInteger('old_value')->nullable();
            $table->bigInteger('new_value');
            $table->string('change_type')->comment('manual, auto, reset, etc');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('website_visitors', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('device')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('referrer')->nullable();
            $table->string('page')->nullable();
            $table->date('date');
            $table->boolean('is_unique')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();
            
            $table->index(['date', 'is_unique']);
            $table->index('session_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('website_visitors');
        Schema::dropIfExists('website_statistic_logs');
        Schema::dropIfExists('website_statistics');
    }
};