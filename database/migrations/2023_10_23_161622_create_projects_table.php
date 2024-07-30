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
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('public_name')->nullable();
            $table->string('public_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(0);
            $table->date('established_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
