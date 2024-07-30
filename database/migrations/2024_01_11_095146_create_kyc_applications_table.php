<?php

use App\Enum\KycApplicationStatus;
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
        Schema::create('kyc_applications', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->enum('application_status', [
                KycApplicationStatus::Uploaded->value,
                KycApplicationStatus::Rejected->value,
                KycApplicationStatus::Approved->value,
                KycApplicationStatus::Pending->value,
            ])->default(KycApplicationStatus::Pending->value);
            $table->string('reference')->nullable();
            $table->text('internal_note')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::table('kyc_applications', function (Blueprint $table): void {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_applications');
    }
};
