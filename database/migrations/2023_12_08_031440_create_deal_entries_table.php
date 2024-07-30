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
        Schema::create('deal_entries', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('deal_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->enum('status', ['accepted', 'draft', 'rejected', 'sent']);
            $table->decimal('dealable_quantity', 12, 4);
            $table->decimal('billable_price', 12, 4)->nullable();
            $table->integer('billable_quantity')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('deal_entries', function (Blueprint $table): void {
            $table->foreign('deal_id')->references('id')->on('deals')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_entries');
    }
};
