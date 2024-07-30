<?php

namespace App\Repositories;

use App\Enum\PdfType;
use App\Interface\Repositories\PdfTemplateRepositoryInterface;
use App\Models\PdfTemplate;

class PdfTemplateRepository implements PdfTemplateRepositoryInterface
{
    public function findDefaultTemplate()
    {
        return PdfTemplate::where('is_default', true)->first();
    }

    public function findInvoicePdfTemplateByProjectId($projectId)
    {
        return PdfTemplate::where('project_id', $projectId)
            ->where('type', PdfType::Invoice->value)
            ->first();
    }
}
