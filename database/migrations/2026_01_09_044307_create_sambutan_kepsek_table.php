<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sambutan_kepsek', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi'); // Kolom utama untuk konten sambutan
            $table->timestamps(); // Opsional, bisa dihapus jika tidak perlu
        });
    }

    public function down()
    {
        Schema::dropIfExists('sambutan_kepsek');
    }
};