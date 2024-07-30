<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::updateOrCreate(['name' => 'English', 'code' => 'en']);
        Language::updateOrCreate(['name' => 'Norsk', 'code' => 'no']);
        Language::updateOrCreate(['name' => 'Svenska', 'code' => 'sv']);
    }
}
