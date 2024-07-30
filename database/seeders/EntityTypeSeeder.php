<?php

namespace Database\Seeders;

use App\Models\EntityType;
use Illuminate\Database\Seeder;

class EntityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Individual',
            ],
            [
                'name' => 'Company',
            ],
        ];

        foreach ($types as $type) {
            EntityType::create([
                'name' => $type['name'],
            ]);
        }
    }
}
