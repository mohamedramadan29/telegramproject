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
        Schema::create('message_replays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->references('id')->on('supports')->cascadeOnDelete();
            $table->text('replay');
            $table->text('attachments')->nullable();
            $table->string('user_replay')->default('admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_replays');
    }
};
