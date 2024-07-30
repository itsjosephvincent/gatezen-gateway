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
        Schema::create('email_templates', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('email_type_id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('name');
            $table->string('from_name');
            $table->string('from_email');
            $table->json('cc_emails')->nullable();
            $table->json('bcc_emails')->nullable();
            $table->boolean('is_default')->default(false);
            $table->string('subject');
            $table->longText('body_text');
            $table->longText('body_html');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('email_templates', function (Blueprint $table): void {
            $table->foreign('email_type_id')->references('id')->on('email_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
