<?php

namespace Database\Seeders;

use App\Models\ExternalDataType;
use Illuminate\Database\Seeder;

class ExternalDataTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExternalDataType::updateOrCreate(['name' => 'TGI User']);
        ExternalDataType::updateOrCreate(['name' => 'TGI Share']);
        ExternalDataType::updateOrCreate(['name' => 'TGI Transaction']);
        ExternalDataType::updateOrCreate(['name' => 'Volver Zen']);
        ExternalDataType::updateOrCreate(['name' => 'REES User']);
        ExternalDataType::updateOrCreate(['name' => 'REES Share']);
        ExternalDataType::updateOrCreate(['name' => 'ABC User']);
        ExternalDataType::updateOrCreate(['name' => 'ABC Share']);
        ExternalDataType::updateOrCreate(['name' => 'Zoho CRM Lead']);
        ExternalDataType::updateOrCreate(['name' => 'Zoho CRM Contact']);
        ExternalDataType::updateOrCreate(['name' => 'Zoho CRM Account']);
        ExternalDataType::updateOrCreate(['name' => 'Zoho Books Customer']);
        ExternalDataType::updateOrCreate(['name' => 'Zoho Books Invoice']);
        ExternalDataType::updateOrCreate(['name' => 'Zoho Sign Agreement']);
        ExternalDataType::updateOrCreate(['name' => 'Zoho Books Contact Person']);
    }
}
