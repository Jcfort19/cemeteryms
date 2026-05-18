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
        Schema::create('cemetery_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cemetery_section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->string('lot_number');
            $table->string('block')->nullable();
            $table->decimal('area_sqm', 8, 2)->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->string('status')->default('vacant')->index();
            $table->json('polygon')->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['cemetery_section_id', 'lot_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cemetery_lots');
    }
};
