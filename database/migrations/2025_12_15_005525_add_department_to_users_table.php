<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
       // $table->string('department')->nullable()->after('email');
       if (!Schema::hasColumn('users', 'avatar')) {
             $table->string('avatar')->nullable()->after('email'); // Saya ubah after 'email' karena department sudah ada
        }
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
