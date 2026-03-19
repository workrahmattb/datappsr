<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop kelas_id foreign key + column from mtsputras
        Schema::table('mtsputras', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        // Drop kelas_id foreign key + column from mtsputris
        Schema::table('mtsputris', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        // Drop kelas_id foreign key + column from maputras
        Schema::table('maputras', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        // Drop kelas_id foreign key + column from maputris
        Schema::table('maputris', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        // Drop kelas_id foreign key + column from pendaftarans (if it exists)
        if (Schema::hasColumn('pendaftarans', 'kelas_id')) {
            Schema::table('pendaftarans', function (Blueprint $table) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            });
        }

        // Drop kelas_id foreign key from nilais (if it exists)
        if (Schema::hasColumn('nilais', 'kelas_id')) {
            Schema::table('nilais', function (Blueprint $table) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            });
        }

        // Drop kelas_id from pengajarans (if it exists)
        if (Schema::hasColumn('pengajarans', 'kelas_id')) {
            Schema::table('pengajarans', function (Blueprint $table) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            });
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
