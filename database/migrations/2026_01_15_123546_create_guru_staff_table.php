<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru_staff', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['kepala_sekolah', 'wakil_kepala_sekolah', 'kepala_jurusan', 'guru', 'staff'])->default('guru');
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('bidang')->nullable(); // Untuk wakil kepala: Kurikulum, Kesiswaan, dll
            $table->string('jurusan')->nullable(); // Untuk kepala jurusan
            $table->text('deskripsi')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->integer('tahun_masuk')->nullable();
            $table->integer('urutan')->default(0);
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru_staff');
    }
};