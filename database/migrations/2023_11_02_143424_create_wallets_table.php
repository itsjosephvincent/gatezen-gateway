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
        Schema::create('wallets', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->morphs('holdable');
            $table->nullableMorphs('belongable');
            $table->string('slug')->index();
            $table->string('description')->nullable();
            $table->json('meta')->nullable();
            $table->decimal('balance', 12, 4)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transactions', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->morphs('payable');
            $table->foreignId('wallet_id')->constrained();
            $table->decimal('amount', 12, 4)->default(0);
            $table->boolean('is_pending')->default(true);
            $table->string('description')->nullable();
            $table->json('meta')->nullable();
            $table->enum('transaction_type', ['Bought', 'Sold', 'Transferred']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('wallets');
    }
};
