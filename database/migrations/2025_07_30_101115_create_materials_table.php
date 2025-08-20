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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dubbing_id')->constrained()->onDelete('cascade');
            $table->string('file_type');
            $table->integer('season_number')->nullable();
            $table->integer('episode_number')->nullable();
            $table->boolean('script_exists')->default(false);
            $table->boolean('ae_file_exists')->default(false);
            $table->integer('file_duration')->nullable();
            $table->string('video_path')->nullable();
            $table->string('script_file_path')->nullable();
            $table->string('ae_file_path')->nullable();
            $table->enum('status', ['sent_to_studio', 'completed'])->default('sent_to_studio');
            $table->integer('duration')->nullable();
            $table->timestamp('studio_start_date')->nullable();
            $table->timestamp('studio_end_date')->nullable();
            $table->timestamp('received_from_producer')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
