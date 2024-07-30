<?php

namespace App\Imports;

use App\Models\ExternalData;
use App\Models\ExternalDataType;
use App\Models\Language;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements SkipsEmptyRows, ToCollection, WithChunkReading, WithCustomCsvSettings, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            // If DNN ID is not set, skip and continue to next.
            if (! $row['dnn_id'] || empty($row['dnn_id'])) {
                continue;
            }
            // Check if user exists OR create a new one
            $user = User::where('email', $row['email'])->first();

            if (! $user) {
                $user = new User();
                $user->firstname = $row['first_name'];
                $user->middlename = $row['middle_name'] ?? null;
                $user->lastname = $row['last_name'];
                $user->email = $row['email'];
                $user->password = Hash::make(Str::random(12));
                if ($row['language'] && $language = Language::where('code', $row['language'])->first()) {
                    $user->language()->associate($language);
                }
                $user->save();
            }

            if ($row['external_zoho_contact_id']) {
                $external_type_zoho_crm_contact = ExternalDataType::where('name', 'Zoho CRM Contact')->first();
                $externable_data_zoho_crm_contact = $user->external->where('external_data_type_id', $external_type_zoho_crm_contact->id)->first();

                if (! $externable_data_zoho_crm_contact) {
                    ExternalData::create(
                        [
                            'external_id' => $row['external_zoho_contact_id'],
                            'data' => ['contact_id' => $row['external_zoho_contact_id']],
                            'external_data_type_id' => $external_type_zoho_crm_contact->id,
                            'externable_type' => "App\Models\User",
                            'externable_id' => $user->id,
                        ]
                    );
                }
            }

            if ($row['dnn_id']) {
                $external_type_tgi = ExternalDataType::where('name', 'TGI')->first();
                $externable_data_tgi = $user->external->where('external_data_type_id', $external_type_tgi->id)->first();

                if (! $externable_data_tgi) {
                    ExternalData::create(
                        [
                            'external_id' => $row['dnn_id'],
                            'data' => ['user_id' => $row['dnn_id']],
                            'external_data_type_id' => $external_type_tgi->id,
                            'externable_type' => "App\Models\User",
                            'externable_id' => $user->id,
                        ]
                    );
                }
            }

            if ($row['discord_id']) {
                UserMeta::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'type' => 'discord_id',
                    ],
                    [
                        'value' => $row['discord_id'],
                    ]
                );
            }
        }
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
        ];
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
