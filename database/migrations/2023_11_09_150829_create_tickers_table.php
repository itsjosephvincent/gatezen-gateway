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
        Schema::create('tickers', function (Blueprint $table): void {
            $table->id();
            $table->uuid();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->string('ticker')->unique();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('website_url')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('currency_id')->constrained();
            $table->string('market')->nullable();
            $table->integer('market_cap')->nullable();
            $table->string('primary_exchange')->nullable();
            $table->foreignId('language_id')->nullable()->constrained();
            $table->boolean('is_active')->default(1);
            $table->decimal('price', 12, 4)->default(0);
            $table->string('price_last_traded')->nullable();
            $table->integer('authorized_shares')->nullable();
            $table->integer('outstanding_shares')->nullable();
            $table->timestamp('list_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickers');
    }
};
