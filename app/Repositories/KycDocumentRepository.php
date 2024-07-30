<?php

namespace App\Repositories;

use App\Enum\KycDocumentStatus;
use App\Enum\Permissions;
use App\Models\KycDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KycDocumentRepository
{
    public function createKycDocument(int $kycApplicationId, int $docTypeId)
    {
        $kyc = new KycDocument();
        $kyc->kyc_application_id = $kycApplicationId;
        $kyc->document_type_id = $docTypeId;
        $kyc->save();

        return $kyc->fresh();
    }

    public function insertMedia($payload, $kycDocumentId)
    {
        $kyc = KycDocument::findOrFail($kycDocumentId);
        if ($payload->proof_of_id) {
            $kyc->addMediaFromRequest('proof_of_id')->toMediaCollection('kyc_media');
        } else {
            $kyc->addMediaFromRequest('proof_of_address')->toMediaCollection('kyc_media');
        }
        $filePath = $kyc->getMedia('kyc_media')->last()->getPath();
        $appPath = Str::after($filePath, 'user/');
        $kyc->file = $appPath;
        $kyc->save();

        return $kyc->fresh();
    }

    public function update(array $data, $record)
    {
        $kyc = KycDocument::with([
            'kyc_application',
            'kyc_application.user',
        ])->findOrFail($record->id);
        $kyc->status = $data['status'];
        $kyc->internal_note = $data['internal_note'] ?? null;
        $kyc->external_note = $data['external_note'] ?? null;
        $kyc->rejected_at = $data['rejected_at'] ?? null;
        $kyc->approved_at = $data['approved_at'] ?? null;
        $kyc->save();

        return $kyc->refresh();
    }

    public function download($kycDocumentId)
    {
        $user = auth()->user();
        $userPermission = json_decode($user->getPermissionNames(), true);
        if (in_array(Permissions::ViewPermissions->value, $userPermission)) {
            $document = KycDocument::findOrFail($kycDocumentId);
            $filePath = 'user/'.$document->file;

            return Storage::download($filePath);
        }

        return false;
    }

    public function findUserKycDocumentStatuses(int $kycApplicationId)
    {
        return KycDocument::where('kyc_application_id', $kycApplicationId)
            ->pluck('status');
    }

    public function findKycDocumentByUserIdAndDocType(object $payload, int $userId)
    {
        return KycDocument::with([
            'kyc_application',
            'document_type',
        ])
            ->where('status', KycDocumentStatus::Pending->value)
            ->whereHas('kyc_application', function ($query) use ($userId): void {
                $query->where('user_id', $userId);
            })
            ->WhereHas('document_type', function ($query) use ($payload): void {
                $query->where('id', $payload->document_type_id);
            })
            ->first();
    }

    public function deleteDocumentById(int $kycDocumentId)
    {
        return KycDocument::findOrFail($kycDocumentId)
            ->delete();
    }
}
