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
        Schema::create('pdf_templates', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('name');
            $table->enum('type', ['creditnote', 'deal', 'invoice', 'portfolio', 'sale']);
            $table->boolean('is_default')->default(false);
            $table->longText('html_template');
            $table->json('pdf_settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('pdf_templates', function (Blueprint $table): void {
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_templates');
    }
};
