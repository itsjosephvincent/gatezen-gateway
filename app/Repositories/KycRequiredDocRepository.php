<?php

namespace App\Repositories;

use App\Models\KycRequiredDoc;

class KycRequiredDocRepository
{
    public function createKycRequiredDocs(int $docTypeId, int $kycApplicationId): void
    {
        $requiredDocs = new KycRequiredDoc();
        $requiredDocs->kyc_application_id = $kycApplicationId;
        $requiredDocs->document_type_id = $docTypeId;
        $requiredDocs->save();
    }
}
