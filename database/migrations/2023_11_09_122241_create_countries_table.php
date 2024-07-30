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
        Schema::create('countries', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('phone_code');
            $table->string('iso_2');
            $table->string('iso_3');
            $table->foreignId('currency_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('languages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('languages');
    }
};
