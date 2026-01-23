<?php
// database/migrations/2024_01_01_000000_create_agenda_sekolah_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agenda_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->string('bulan')->nullable(); // Untuk format "Jun 2025"
            $table->integer('hari')->nullable(); // Untuk tanggal 15
            $table->time('waktu')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('warna')->default('#6b02b1'); // Untuk styling
            $table->integer('urutan')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agenda_sekolah');
    }
};