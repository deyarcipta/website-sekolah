<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimoni_alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('program_studi')->nullable();
            $table->string('angkatan')->nullable();
            $table->text('testimoni');
            $table->string('foto')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimoni_alumni');
    }
};