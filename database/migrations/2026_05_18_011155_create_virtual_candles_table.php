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
        Schema::create('virtual_candles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorial_page_id')->constrained()->cascadeOnDelete();
            $table->string('visitor_name')->nullable();
            $table->string('visitor_ip', 45)->nullable();
            $table->timestamp('lit_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_candles');
    }
};
