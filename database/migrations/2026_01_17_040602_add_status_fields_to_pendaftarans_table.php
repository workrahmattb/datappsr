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
            $table->enum('status_pendaftaran', ['pending', 'completed'])->default('pending')->after('jenjang_pendidikan');
            $table->unsignedBigInteger('student_id')->nullable()->after('status_pendaftaran');
            $table->string('student_type')->nullable()->after('student_id')->comment('mtsputri, mtsputra, maputri, maputra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['status_pendaftaran', 'student_id', 'student_type']);
        });
    }
};
