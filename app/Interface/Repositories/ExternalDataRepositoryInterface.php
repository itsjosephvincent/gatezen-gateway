<?php

namespace App\Interface\Repositories;

use App\Models\ExternalDataType;
use App\Models\Transaction;
use App\Models\User;

interface ExternalDataRepositoryInterface
{
    public function storeUser($userData, $externalDataTypeId, User $user);

    public function storeZohoBooksInvoice($invoiceData, $externalDataTypeId, User $user);

    public function storeTransaction($userData, $data, $externalDataTypeId, Transaction $transaction);

    public function showUser($user, ExternalDataType $externalDataType);

    public function showTransaction($user, int $externalDataTypeId);

    public function showByExternalId(string $externalId);

    public function showUserExternalData($email, $externalDataTypeId);

    public function showByUserIdExternalId(User $user, $externalDataTypeId);
}
