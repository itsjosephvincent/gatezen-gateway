<?php

namespace App\Interface\Repositories;

interface DocumentTypeRepositoryInterface
{
    public function findIdAndAddress();

    public function findDocumentTypeList();

    public function findDocumentTypeById(int $docTypeId);
}
