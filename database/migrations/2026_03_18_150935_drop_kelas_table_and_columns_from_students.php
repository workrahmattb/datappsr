<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['mtsputras', 'mtsputris', 'maputras', 'maputris', 'pendaftarans', 'nilais', 'pengajarans'];

        foreach ($tables as $tableName) {
            if (Schema::hasColumn($tableName, 'kelas_id')) {
                // Try to drop foreign key if it exists
                try {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->dropForeign(['kelas_id']);
                    });
                } catch (\Exception $e) {
                    // Ignore exception if foreign key doesn't exist
                }

                // Drop the column
                try {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->dropColumn('kelas_id');
                    });
                } catch (\Exception $e) {
                    // Ignore exception if column doesn't exist or other dropping error
                }
            }
        }

        // Finally, drop the kelas table itself
        Schema::dropIfExists('kelas');
    }

    public function down(): void
    {
        // Recreate kelas table
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->nullable();
            $table->timestamps();
        });

        // Re-add kelas_id to student tables
        Schema::table('mtsputras', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('tahun_ajaran')->constrained('kelas')->nullOnDelete();
        });
        Schema::table('mtsputris', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('tahun_ajaran')->constrained('kelas')->nullOnDelete();
        });
        Schema::table('maputras', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('tahun_ajaran')->constrained('kelas')->nullOnDelete();
        });
        Schema::table('maputris', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('tahun_ajaran')->constrained('kelas')->nullOnDelete();
        });
    }
};
