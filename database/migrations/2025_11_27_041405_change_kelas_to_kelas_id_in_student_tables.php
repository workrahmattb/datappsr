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
        // Update mtsputris table
        Schema::table('mtsputris', function (Blueprint $table) {
            $table->dropColumn('kelas');
            $table->foreignId('kelas_id')
                ->nullable()
                ->after('tahun_ajaran')
                ->constrained('kelas')
                ->nullOnDelete();
        });

        // Update mtsputras table
        Schema::table('mtsputras', function (Blueprint $table) {
            $table->dropColumn('kelas');
            $table->foreignId('kelas_id')
                ->nullable()
                ->after('tahun_ajaran')
                ->constrained('kelas')
                ->nullOnDelete();
        });

        // Update maputris table
        Schema::table('maputris', function (Blueprint $table) {
            $table->dropColumn('kelas');
            $table->foreignId('kelas_id')
                ->nullable()
                ->after('tahun_ajaran')
                ->constrained('kelas')
                ->nullOnDelete();
        });

        // Update maputras table
        Schema::table('maputras', function (Blueprint $table) {
            $table->dropColumn('kelas');
            $table->foreignId('kelas_id')
                ->nullable()
                ->after('tahun_ajaran')
                ->constrained('kelas')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse mtsputris table
        Schema::table('mtsputris', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
            $table->string('kelas')->nullable()->after('tahun_ajaran');
        });

        // Reverse mtsputras table
        Schema::table('mtsputras', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
            $table->string('kelas')->nullable()->after('tahun_ajaran');
        });

        // Reverse maputris table
        Schema::table('maputris', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
            $table->string('kelas')->nullable()->after('tahun_ajaran');
        });

        // Reverse maputras table
        Schema::table('maputras', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
            $table->string('kelas')->nullable()->after('tahun_ajaran');
        });
    }
};
