<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('investor_favourite_sector', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained()->onDelete('cascade');
            $table->foreignId('favourite_sector_id')->constrained('favourite_sectors')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('investor_favourite_sector');
    }
};
