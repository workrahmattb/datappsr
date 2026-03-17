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
        // Add kelas column to mtsputris table
        Schema::table('mtsputris', function (Blueprint $table) {
            $table->string('kelas')->nullable()->after('tahun_ajaran');
        });

        // Add kelas column to mtsputras table
        Schema::table('mtsputras', function (Blueprint $table) {
            $table->string('kelas')->nullable()->after('tahun_ajaran');
        });

        // Add kelas column to maputris table
        Schema::table('maputris', function (Blueprint $table) {
            $table->string('kelas')->nullable()->after('tahun_ajaran');
        });

        // Add kelas column to maputras table
        Schema::table('maputras', function (Blueprint $table) {
            $table->string('kelas')->nullable()->after('tahun_ajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove kelas column from mtsputris table
        Schema::table('mtsputris', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });

        // Remove kelas column from mtsputras table
        Schema::table('mtsputras', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });

        // Remove kelas column from maputris table
        Schema::table('maputris', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });

        // Remove kelas column from maputras table
        Schema::table('maputras', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });
    }
};
