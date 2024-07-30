<?php

namespace App\Interface\Repositories;

interface PdfTemplateRepositoryInterface
{
    public function findDefaultTemplate();

    public function findInvoicePdfTemplateByProjectId(int $projectId);
}
