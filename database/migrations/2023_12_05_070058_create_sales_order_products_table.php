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
        Schema::create('sales_order_products', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_order_id');
            $table->morphs('sellable');
            $table->string('product_name');
            $table->longText('description')->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->string('position')->nullable();
            $table->decimal('price', 12, 4);
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('sales_order_products', function (Blueprint $table): void {
            $table->foreign('sales_order_id')->references('id')->on('sales_orders')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_products');
    }
};
