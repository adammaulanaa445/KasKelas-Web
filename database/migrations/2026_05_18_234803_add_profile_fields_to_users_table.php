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
        
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('negara')->nullable();
        $table->string('daerah')->nullable();
        $table->string('kategori')->nullable();
        $table->string('sub_kategori')->nullable();
        $table->string('visitor_password')->nullable(); // Password untuk teman
        $table->timestamp('expired_at')->nullable();    // Masa aktif akun
    });
}
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
