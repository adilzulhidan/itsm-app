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
            
            
            $table->string('ticket_code')->unique();
            
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('subject');
            $table->string('department')->nullable();
            $table->string('category');
            $table->string('priority')->default('medium');
            
            
            $table->string('status')->default('Menunggu Persetujuan Manager'); 
            

            $table->text('description');
            $table->string('attachment')->nullable();
            
          
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            
            
            $table->foreignId('approved_by_manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('manager_approved_at')->nullable();

           
            $table->foreignId('approved_by_it_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('it_approved_at')->nullable();
            
     
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