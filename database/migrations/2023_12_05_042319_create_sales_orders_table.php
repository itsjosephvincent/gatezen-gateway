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
        Schema::create('sales_orders', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('language_id')->default(1);
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('template_id')->nullable();
            $table->enum('status', ['accepted', 'cancelled', 'draft', 'invoiced', 'pending', 'sent'])->default('draft');
            $table->string('order_number')->nullable();
            $table->date('order_date');
            $table->longText('note')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('sales_orders', function (Blueprint $table): void {
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('template_id')->references('id')->on('pdf_templates')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
