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
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->float('temperature', 4, 1); // Contoh: 27.5
            $table->float('humidity', 4, 1);    // Contoh: 64.0
            $table->string('fan_status', 5)->default('OFF');
            $table->string('humidifier_status', 5)->default('OFF');

            // Membuat kolom created_at dan updated_at secara otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
