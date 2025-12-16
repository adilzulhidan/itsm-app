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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            
            // Kode Aset (AST-XXXX)
            $table->string('asset_code')->unique();
            
            // Info Perangkat
            $table->string('name');
            $table->string('type');
            $table->string('serial_number')->unique(); // Pastikan kolom ini ada
            
            // Info Tambahan
            $table->date('purchase_date')->nullable();
            $table->string('status')->default('Active');
            $table->string('location')->nullable();
            
            // Relasi ke User (Pemilik Aset)
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    } // <--- KURUNG KURAWAL INI TADI KEMUNGKINAN HILANG

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};