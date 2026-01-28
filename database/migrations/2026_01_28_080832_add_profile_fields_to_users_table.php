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
        Schema::table('users', function (Blueprint $table) {
            // Role sudah ada, tidak perlu ditambahkan lagi
            // $table->enum('role', ['admin', 'superadmin'])->default('admin');
            
            // Tambahkan kolom yang belum ada
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }
            
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('is_active');
            }
            
            if (!Schema::hasColumn('users', 'foto_profil')) {
                $table->string('foto_profil')->nullable()->after('last_login_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            $table->dropColumn(['is_active', 'last_login_at', 'foto_profil']);
        });
    }
};