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
        Schema::create('external_data_types', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('external_datas', function (Blueprint $table): void {
            $table->id();
            $table->string('external_id');
            $table->json('data');
            $table->foreignId('external_data_type_id')->constrained();
            $table->morphs('externable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_datas');
        Schema::dropIfExists('external_data_types');
    }
};
