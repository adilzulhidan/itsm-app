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
            // Menambahkan kolom department (nullable = boleh kosong)
            // diletakkan setelah kolom email agar rapi
            $table->string('department')->nullable()->after('email');
            
            // Menambahkan kolom avatar untuk path foto profil
            $table->string('avatar')->nullable()->after('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['department', 'avatar']);
        });
    }
};