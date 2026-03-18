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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            
            // Polymorphic relation to student (Mtsputri, Mtsputra, Maputri, Maputra)
            $table->unsignedBigInteger('siswa_id');
            $table->string('siswa_type');
            
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            
            $table->enum('semester', ['1', '2']);
            $table->string('tahun_ajaran');
            $table->enum('jenis_nilai', ['Pengetahuan', 'Keterampilan', 'Sikap']);
            
            $table->integer('nilai')->default(0);
            $table->string('predikat', 2)->nullable();
            $table->text('deskripsi')->nullable();
            
            $table->timestamps();

            // Index for polymorphic relation
            $table->index(['siswa_id', 'siswa_type']);
            
            // Prevent duplicate nilai entries
            $table->unique([
                'siswa_id', 
                'siswa_type', 
                'mata_pelajaran_id', 
                'semester', 
                'tahun_ajaran', 
                'jenis_nilai'
            ], 'unique_nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
