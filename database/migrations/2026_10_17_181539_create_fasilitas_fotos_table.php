<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fasilitas_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fasilitas_id')->constrained('fasilitas')->cascadeOnDelete();
            $table->string('path');
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->index(['fasilitas_id', 'urutan']);
        });

        // Kolom cover boleh kosong bila semua foto dihapus.
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->string('gambar')->nullable()->change();
        });

        // Pindahkan gambar lama menjadi foto pertama di galeri.
        DB::table('fasilitas')
            ->whereNotNull('gambar')
            ->where('gambar', '!=', '')
            ->orderBy('id')
            ->get(['id', 'gambar'])
            ->each(function (object $row): void {
                DB::table('fasilitas_fotos')->insert([
                    'fasilitas_id' => $row->id,
                    'path' => $row->gambar,
                    'urutan' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas_fotos');

        Schema::table('fasilitas', function (Blueprint $table) {
            $table->string('gambar')->nullable(false)->change();
        });
    }
};
