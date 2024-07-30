<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\CurrencyType;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CurrencyType::updateOrCreate(['name' => 'Fiat']);
        CurrencyType::updateOrCreate(['name' => 'Crypto']);
        CurrencyType::updateOrCreate(['name' => 'Private']);

        $currencies = [
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'type' => 'Fiat',
            ],
            [
                'name' => 'Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'type' => 'Fiat',
            ],
            [
                'name' => 'Pund',
                'code' => 'GBP',
                'symbol' => '£',
                'type' => 'Fiat',
            ],
            [
                'name' => 'Norwegian Kroner',
                'code' => 'NOK',
                'symbol' => 'Kr',
                'type' => 'Fiat',
            ],
            [
                'name' => 'Swedish Kroner',
                'code' => 'SEK',
                'symbol' => 'Kr',
                'type' => 'Fiat',
            ],
        ];

        foreach ($currencies as $new_currency) {
            $currency = Currency::where('name', $new_currency['name'])
                ->where('code', $new_currency['code'])
                ->first();

            if (! $currency) {
                $type = CurrencyType::where(['name' => $new_currency['type']])->first();

                $currency = new Currency();
                $currency->name = $new_currency['name'];
                $currency->code = $new_currency['code'];
                $currency->symbol = $new_currency['symbol'];
                $currency->currencyType()->associate($type);
                $currency->save();
            }
        }
    }
}
