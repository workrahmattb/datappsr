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
        Schema::table('mtsputras', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('fototransfer');
        });

        Schema::table('mtsputris', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('fototransfer');
        });

        Schema::table('maputras', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('fototransfer');
        });

        Schema::table('maputris', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('fototransfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtsputras', function (Blueprint $table) {
            $table->dropColumn('foto');
        });

        Schema::table('mtsputris', function (Blueprint $table) {
            $table->dropColumn('foto');
        });

        Schema::table('maputras', function (Blueprint $table) {
            $table->dropColumn('foto');
        });

        Schema::table('maputris', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
