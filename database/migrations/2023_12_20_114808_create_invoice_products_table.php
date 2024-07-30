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
        Schema::create('invoice_products', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id');
            $table->morphs('invoiceable');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name');
            $table->decimal('price', 12, 4)->nullable();
            $table->integer('quantity');
            $table->longText('description')->nullable();
            $table->string('position')->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('invoice_products', function (Blueprint $table): void {
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products');
    }
};
