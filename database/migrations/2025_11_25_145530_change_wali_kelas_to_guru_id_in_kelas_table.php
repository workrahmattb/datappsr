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
        Schema::table('kelas', function (Blueprint $table) {
            // Drop old wali_kelas column
            $table->dropColumn('wali_kelas');
            
            // Add guru_id foreign key
            $table->foreignId('guru_id')
                ->nullable()
                ->after('tahun_ajaran')
                ->constrained('gurus')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Drop foreign key and guru_id column
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
            
            // Restore old wali_kelas column
            $table->string('wali_kelas')->nullable();
        });
    }
};
