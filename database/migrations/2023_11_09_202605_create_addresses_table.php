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
        Schema::create('addresses', function (Blueprint $table): void {
            $table->id();
            $table->morphs('addressable');
            $table->string('co', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('street2', 100)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('postal')->nullable();
            $table->string('county', 30)->nullable();
            $table->foreignId('countries_id', 30)->constrained();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
