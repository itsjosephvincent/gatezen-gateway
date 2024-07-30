<?php

namespace App\Repositories;

use App\Interface\Repositories\DocumentTypeRepositoryInterface;
use App\Models\DocumentType;

class DocumentTypeRepository implements DocumentTypeRepositoryInterface
{
    public function findIdAndAddress()
    {
        return DocumentType::whereIn('name', ['ID', 'Utility Bill'])
            ->pluck('id');
    }

    public function findDocumentTypeList()
    {
        return DocumentType::all();
    }

    public function findDocumentTypeById($docTypeId)
    {
        return DocumentType::findOrFail($docTypeId);
    }
}
