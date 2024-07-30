<?php

namespace App\Repositories;

use App\Enum\KycApplicationStatus;
use App\Models\KycApplication;
use Carbon\Carbon;

class KycApplicationRepository
{
    public function createKycApplication($user)
    {
        $kycApplication = new KycApplication();
        $kycApplication->user_id = $user->id;
        $kycApplication->save();

        return $kycApplication->fresh();
    }

    public function findKycApplicationByUserId(int $userId)
    {
        return KycApplication::with([
            'kyc_documents',
            'kyc_documents.document_type',
        ])
            ->where('user_id', $userId)
            ->first();
    }

    public function findById(int $kycId)
    {
        return KycApplication::with(['user'])->findOrFail($kycId);
    }

    public function updateKycStatus($data, $userId)
    {
        $kyc = KycApplication::where('user_id', $userId)->first();
        $kyc->application_status = $data['application_status'];
        if ($data['application_status'] === KycApplicationStatus::Approved->value) {
            $kyc->completed_at = Carbon::now();
        }
        $kyc->save();

        return $kyc->fresh();
    }

    public function updateKycInternalNoteReference($data, $userId)
    {
        $kyc = KycApplication::where('user_id', $userId)->first();
        $kyc->internal_note = $data['internal_note'] ?? null;
        $kyc->reference = $data['reference'] ?? null;
        $kyc->save();

        return $kyc->fresh();
    }
}
