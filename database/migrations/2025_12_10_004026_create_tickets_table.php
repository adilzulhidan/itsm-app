<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            // Kode Tiket Unik (Misal: IT-20231212-XYZ)
            $table->string('ticket_code')->unique();
            
            // Pembuat Tiket
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('subject');
            $table->string('department')->nullable();
            $table->string('category');
            $table->string('priority')->default('medium');
            
            // --- [PERBAIKAN DI SINI] ---
            // Mengubah ENUM menjadi STRING agar fleksibel
            // Default disesuaikan dengan status awal di Controller
            $table->string('status')->default('Menunggu Persetujuan Manager'); 
            // ---------------------------

            $table->text('description');
            $table->string('attachment')->nullable();
            
            // Teknisi yang mengerjakan (Opsional)
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            
            // === KOLOM APPROVAL (PERSETUJUAN) ===
            // 1. Function Head (Manager)
            $table->foreignId('approved_by_manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('manager_approved_at')->nullable();

            // 2. IT Dept Head
            $table->foreignId('approved_by_it_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('it_approved_at')->nullable();
            
            // === KOLOM REJECTION (PENOLAKAN) ===
            // Penting ditambahkan karena ada fitur reject di Controller
            $table->text('rejection_reason')->nullable();
            $table->foreignId('rejected_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('rejected_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};