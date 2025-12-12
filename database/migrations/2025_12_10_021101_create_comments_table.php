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
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        // Hubungkan ke tabel tickets (jika tiket dihapus, komentar ikut terhapus)
        $table->foreignId('ticket_id')->constrained()->onDelete('cascade');

        // Hubungkan ke tabel users (siapa yang nulis komentar)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->text('message'); // Isi komentarnya
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
