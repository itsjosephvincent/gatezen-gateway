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
        Schema::create('products', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('name');
            $table->enum('type', ['physical', 'service', 'ticker'])->default('physical');
            $table->longText('description')->nullable();
            $table->decimal('price', 12, 4);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
