<?php

namespace App\Repositories;

use App\Interface\Repositories\ExternalDataRepositoryInterface;
use App\Models\ExternalData;
use App\Models\ExternalDataType;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExternalDataRepository implements ExternalDataRepositoryInterface
{
    public function storeUser($userData, $externalDataTypeId, User $user)
    {
        $externalData = new ExternalData();
        $externalData->external_id = $userData['UserID'];
        $externalData->data = $userData;
        $externalData->external_data_type_id = $externalDataTypeId;
        $externalData->externable_type = get_class($user);
        $externalData->externable_id = $user->id;
        $externalData->save();

        return $externalData->fresh();
    }

    public function storeZohoBooksInvoice($invoiceData, $externalDataTypeId, User $user)
    {
        $externalData = new ExternalData();
        $externalData->external_id = $invoiceData->invoice_number;
        $externalData->data = json_encode($invoiceData);
        $externalData->external_data_type_id = $externalDataTypeId;
        $externalData->externable_type = get_class($user);
        $externalData->externable_id = $user->id;
        $externalData->save();

        return $externalData->fresh();
    }

    public function storeTransaction($userData, $data, $externalDataTypeId, Transaction $transaction)
    {
        $externalData = new ExternalData();
        $externalData->external_id = $userData;
        $externalData->data = $data;
        $externalData->external_data_type_id = $externalDataTypeId;
        $externalData->externable_type = get_class($transaction);
        $externalData->externable_id = $transaction->id;
        $externalData->save();

        return $externalData->fresh();
    }

    public function showUser($user, ExternalDataType $externalDataType)
    {
        return ExternalData::where('external_id', $user['UserID'])
            ->where('external_data_type_id', $externalDataType->id)
            ->first();
    }

    public function showTransaction($user, int $externalDataTypeId)
    {
        return ExternalData::where('external_id', $user)
            ->where('external_data_type_id', $externalDataTypeId)
            ->first();
    }

    public function showByExternalId(string $externalId)
    {
        return ExternalData::where('external_id', $externalId)->first();
    }

    public function showUserExternalData($email, $externalDataTypeId)
    {
        return DB::table('external_datas')
            ->where('external_data_type_id', $externalDataTypeId)
            ->where('data->Email', $email)
            ->first();
    }

    public function showByUserIdExternalId(User $user, $externalDataTypeId)
    {
        return ExternalData::where('externable_type', 'App\Models\User')
            ->where('externable_id', $user->id)
            ->where('external_data_type_id', $externalDataTypeId)
            ->first();
    }
}
