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
    Schema::create('servers', function (Blueprint $table) {
        $table->id();
        $table->string('name');           // Nama Server (e.g., 'DC-Main')
        $table->string('ip_address');     // IP Address (e.g., '192.168.1.5')
        $table->string('type');           // web, db, firewall, storage
        $table->string('status')->default('online'); // online, offline, warning
        $table->integer('latency')->default(0);      // dalam ms
        $table->integer('load_cpu')->default(0);     // Persentase load CPU
        $table->timestamp('last_checked_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
