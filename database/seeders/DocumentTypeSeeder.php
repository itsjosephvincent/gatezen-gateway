<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'ID',
            ],
            [
                'name' => 'Utility Bill',
            ],
        ];

        foreach ($types as $type) {
            DocumentType::create([
                'name' => $type['name'],
            ]);
        }
    }
}
