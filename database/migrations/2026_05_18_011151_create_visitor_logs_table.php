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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('cemetery_lot_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('logged_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('visitor_name');
            $table->string('visitor_phone')->nullable();
            $table->string('purpose')->nullable();
            $table->timestamp('entered_at');
            $table->timestamp('exited_at')->nullable();
            $table->json('verification_snapshot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
