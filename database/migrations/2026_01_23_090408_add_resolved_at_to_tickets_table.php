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
    Schema::table('tickets', function (Blueprint $table) {
        // Menambahkan kolom timestamp 'resolved_at' yang boleh kosong (nullable)
        $table->timestamp('resolved_at')->nullable()->after('updated_at');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('tickets', function (Blueprint $table) {
        $table->dropColumn('resolved_at');
    });
    }
};
