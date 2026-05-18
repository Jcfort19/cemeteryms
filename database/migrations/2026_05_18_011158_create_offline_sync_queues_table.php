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
        Schema::create('offline_sync_queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collector_id')->constrained('users')->cascadeOnDelete();
            $table->string('device_id')->nullable()->index();
            $table->string('local_uuid')->unique();
            $table->string('type')->default('payment');
            $table->json('payload');
            $table->string('status')->default('pending')->index();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('synced_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_sync_queues');
    }
};
