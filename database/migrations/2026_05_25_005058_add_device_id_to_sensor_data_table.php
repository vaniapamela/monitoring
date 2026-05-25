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
        Schema::table('sensor_data', function (Blueprint $table) {
            // Menambahkan kolom device_id tepat setelah kolom id utama
            // Dibuat nullable() agar data lama kamu yang isi 4 baris tadi tidak error
            $table->foreignId('device_id')->nullable()->after('id')->constrained('devices')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('sensor_data', function (Blueprint $table) {
            // Logika untuk membatalkan jika suatu saat di-rollback
            $table->dropForeign(['device_id']);
            $table->dropColumn('device_id');
        });
    }
};