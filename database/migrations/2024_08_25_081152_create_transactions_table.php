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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trader');
            $table->string('country');
            $table->string('link-id');
            $table->string('balance');
            $table->string('deposits');
            $table->string('deposits-sum');
            $table->string('withdrawals-count');
            $table->string('turnover-clear');
            $table->string('vol-share');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
