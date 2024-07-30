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
        Schema::create('segment_conditions', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('segment_id');
            $table->string('model_type');
            $table->string('field');
            $table->string('operator');
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('segment_conditions', function (Blueprint $table): void {
            $table->foreign('segment_id')->references('id')->on('segments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segment_conditions');
    }
};
