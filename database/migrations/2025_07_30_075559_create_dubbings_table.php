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
        Schema::create('dubbings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id')->constrained()->onDelete('cascade');
            $table->foreignId('studio_id')->constrained()->onDelete('cascade');
            $table->text('language_code');
            $table->integer('duration');
            $table->integer('received_episodes')->default(0);
            $table->integer('downloaded_episodes')->default(0);
            $table->integer('published_episodes')->default(0);
            $table->enum('status', ['material_waiting', 'dubbing', 'published', 'completed', 'in_progress'])->default('material_waiting');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dubbings');
    }
};
