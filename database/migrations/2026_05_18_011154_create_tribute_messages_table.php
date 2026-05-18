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
        Schema::create('tribute_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorial_page_id')->constrained()->cascadeOnDelete();
            $table->string('author_name');
            $table->string('author_email')->nullable();
            $table->text('message');
            $table->string('status')->default('pending')->index();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tribute_messages');
    }
};
