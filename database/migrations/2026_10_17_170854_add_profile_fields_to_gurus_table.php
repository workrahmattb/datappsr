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
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('name');
            $table->string('jabatan')->nullable()->after('nip');
            $table->string('jenis_kelamin')->nullable()->after('jabatan');
            $table->string('pendidikan')->nullable()->after('jenis_kelamin');
            $table->string('email')->nullable()->after('pendidikan');
            $table->text('deskripsi')->nullable()->after('email');
            $table->string('foto')->nullable()->after('deskripsi');
            $table->unsignedInteger('urutan')->default(0)->after('foto');
            $table->boolean('is_active')->default(true)->after('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn([
                'nip',
                'jabatan',
                'jenis_kelamin',
                'pendidikan',
                'email',
                'deskripsi',
                'foto',
                'urutan',
                'is_active',
            ]);
        });
    }
};
