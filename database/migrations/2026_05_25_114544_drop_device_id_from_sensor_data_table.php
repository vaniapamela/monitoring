<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sensor_data', function (Blueprint $table) {

            // kalau ada foreign key
            $table->dropForeign(['device_id']);

            // hapus kolom
            $table->dropColumn('device_id');
        });
    }

    public function down(): void
    {
        Schema::table('sensor_data', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id')->nullable();
        });
    }
};