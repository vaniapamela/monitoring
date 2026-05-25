<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('devices');
    }

    public function down(): void
    {
        Schema::create('devices', function ($table) {
            $table->id();
            $table->timestamps();
        });
    }
};
