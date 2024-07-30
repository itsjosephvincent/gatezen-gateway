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
        Schema::create('invoice_payments', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->uuid();
            $table->unsignedBigInteger('invoice_id');
            $table->decimal('amount', 12, 2);
            $table->unsignedBigInteger('currency_id');
            $table->date('payment_date')->nullable();
            $table->text('description')->nullable();
            $table->text('reference');
            $table->enum('payment_type', ['cash', 'bank_transfer'])->nullable();
            $table->timestamps();
        });

        Schema::table('invoice_payments', function (Blueprint $table): void {
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
};
