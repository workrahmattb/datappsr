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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('bukti_transfer_uang_masuk')->nullable()->after('fototransfer');
            $table->enum('status_bayar_uang_masuk', ['pending', 'uploaded', 'verified', 'rejected'])->default('pending')->after('bukti_transfer_uang_masuk');
            $table->text('keterangan_bayar')->nullable()->after('status_bayar_uang_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['bukti_transfer_uang_masuk', 'status_bayar_uang_masuk', 'keterangan_bayar']);
        });
    }
};
