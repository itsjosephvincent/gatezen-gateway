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
        Schema::create('segment_users', function (Blueprint $table): void {
            $table->unsignedBigInteger('segment_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('segment_users', function (Blueprint $table): void {
            $table->foreign('segment_id')->references('id')->on('segments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segment_users');
    }
};
