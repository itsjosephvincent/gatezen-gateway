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
        Schema::create('deals', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->morphs('dealable');
            $table->text('description')->nullable();
            $table->enum('status', ['cancelled', 'completed', 'draft', 'ongoing', 'paused'])->default('draft');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
