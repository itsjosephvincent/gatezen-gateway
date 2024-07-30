<?php

use App\Enum\KycDocumentStatus;
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
        Schema::create('kyc_documents', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kyc_application_id');
            $table->unsignedBigInteger('document_type_id');
            $table->enum('status', [
                KycDocumentStatus::Pending->value,
                KycDocumentStatus::Waiting->value,
                KycDocumentStatus::Rejected->value,
                KycDocumentStatus::Approved->value,
                KycDocumentStatus::Missing->value,
            ])->default(KycDocumentStatus::Pending->value);
            $table->string('file')->nullable();
            $table->text('internal_note')->nullable();
            $table->text('external_note')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('kyc_documents', function (Blueprint $table): void {
            $table->foreign('kyc_application_id')->references('id')->on('kyc_applications')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('document_type_id')->references('id')->on('document_types')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_documents');
    }
};
