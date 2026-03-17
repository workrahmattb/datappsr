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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kelas (misal: VII A, X IPA 1)
            $table->enum('tingkat', ['MTs', 'MA']); // Tingkat pendidikan
            $table->string('nomor_kelas'); // VII, VIII, IX, X, XI, XII
            $table->string('tahun_ajaran'); // 2024/2025
            $table->string('wali_kelas')->nullable(); // Nama wali kelas
            $table->integer('kapasitas')->default(30); // Kapasitas siswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
