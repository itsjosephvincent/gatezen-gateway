<?php

namespace Database\Seeders;

use App\Enum\ProductType;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Project;
use App\Models\Ticker;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        $projects = [
            [
                'name' => 'Craftwill Capital ESG',
                'public_name' => 'CRAFTWILL CAPITAL ESG 7.0. LTD',
                'website_url' => 'https://www.craftwill-cwi.com/',
                'description' => '',
                'established_at' => '2017-01-01',
                'tag' => 'CWI',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'CWISC',
                        'slug' => 'cwisc',
                        'type' => 'Spot Conv',
                        'name' => 'CWI Spot Convertable',
                        'currency' => 'EUR',
                        'price' => 5.1112,
                        'authorized_shares' => 70000000,
                        'outstanding_shares' => 20000000,
                    ],
                    [
                        'ticker' => 'CWIOP',
                        'slug' => 'cwiop',
                        'type' => 'Ordinary',
                        'name' => 'CWI Ordinary',
                        'currency' => 'EUR',
                        'price' => 1.9514,
                        'authorized_shares' => 30000000,
                        'outstanding_shares' => 100000000,
                    ],
                    [
                        'ticker' => 'ODDSPROFITT',
                        'slug' => 'oddsprofitt',
                        'type' => 'Oddsprofitt',
                        'name' => 'Oddsprofitt',
                        'currency' => 'EUR',
                        'price' => 0,
                        'authorized_shares' => 0,
                        'outstanding_shares' => 0,
                        'tag' => 'ODDSPRO',
                    ],
                    [
                        'ticker' => 'THESIS',
                        'slug' => 'thesis',
                        'type' => 'Thesis',
                        'name' => 'Thesis',
                        'currency' => 'EUR',
                        'price' => 0,
                        'authorized_shares' => 0,
                        'outstanding_shares' => 0,
                        'tag' => 'THESIS',
                    ],
                ],
            ],
            [
                'name' => 'ABC Biotech',
                'public_name' => 'ABC BIOTECH PHARMACEUTICAL CORPORATION PLC',
                'website_url' => '',
                'description' => '',
                'established_at' => '2020-01-01',
                'tag' => 'ABCB',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'ABCB-A',
                        'slug' => 'abcb-a',
                        'type' => 'Class A',
                        'name' => 'ABC Biotech - Class-A',
                        'currency' => 'EUR',
                        'price' => 1.1200,
                        'authorized_shares' => 10000000,
                        'outstanding_shares' => 5000000,
                    ],
                    [
                        'ticker' => 'ABCB-B',
                        'slug' => 'abcb-b',
                        'type' => 'Class B',
                        'name' => 'ABC Biotech - Class-B',
                        'currency' => 'EUR',
                        'price' => 0.9800,
                        'authorized_shares' => 10000000,
                        'outstanding_shares' => 95000000,
                    ],
                ],
            ],
            [
                'name' => 'AQUAONE',
                'public_name' => 'AQUA H2O TECHNOLOGIES PLC',
                'website_url' => 'https://aqaone.com/',
                'description' => '',
                'established_at' => '2022-01-01',
                'tag' => 'AQWT',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'AQWT-A',
                        'slug' => 'aqwt-a',
                        'type' => 'Class A',
                        'name' => 'AQUA H2O - Class A',
                        'currency' => 'EUR',
                        'price' => 4.8000,
                        'authorized_shares' => 10000000,
                        'outstanding_shares' => 5000000,
                    ],
                    [
                        'ticker' => 'AQWT-B',
                        'slug' => 'aqwt-b',
                        'type' => 'Class B',
                        'name' => 'AQUA H2O - Class B',
                        'currency' => 'EUR',
                        'price' => 1.1200,
                        'authorized_shares' => 10000000,
                        'outstanding_shares' => 95000000,
                    ],
                ],
            ],
            [
                'name' => 'NVI Asian Bridge',
                'public_name' => 'NVI ASIAN BRIDGE INTERNATIONAL INVESTORS AIF V.C.I.C. PLC',
                'website_url' => 'https://asianbridgenvi.com/',
                'description' => '',
                'established_at' => '2020-01-01',
                'tag' => 'NVIA',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'NVIA',
                        'slug' => 'nvia',
                        'type' => 'Class A',
                        'name' => 'NVI Asian Bridge, Class-A',
                        'currency' => 'EUR',
                        'price' => 9.4000,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                ],
            ],
            [
                'name' => 'Volver ZEN',
                'public_name' => 'VOLVER AI ESG 7.0. Public Company',
                'website_url' => 'https://www.volverbank.com/',
                'description' => '',
                'established_at' => '2018-01-01',
                'tag' => 'VESG',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'VESG-A',
                        'slug' => 'vesg-a',
                        'type' => 'Class A',
                        'name' => 'Volver Zen, Class-A',
                        'currency' => 'EUR',
                        'price' => 0,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                    [
                        'ticker' => 'VESG-B',
                        'slug' => 'vesg-b',
                        'type' => 'Class B',
                        'name' => 'Volver Zen, Class-B',
                        'currency' => 'EUR',
                        'price' => 0,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                ],
            ],
            [
                'name' => 'GBMT UK',
                'public_name' => 'GLOBAL BIOMOLECULAR TECHNOLOGIES LTD (UK)',
                'website_url' => 'https://www.craftwill-cwi.com/',
                'description' => '',
                'established_at' => '2020-01-01',
                'tag' => 'GBMT-UK',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'GBMT-UK',
                        'slug' => 'gbmt-uk',
                        'type' => 'Class A',
                        'name' => 'GBMT UK - Class A',
                        'currency' => 'EUR',
                        'price' => 3.0800,
                        'authorized_shares' => 10000000,
                        'outstanding_shares' => 10000000,
                    ],
                ],
            ],
            [
                'name' => 'GBMT CY',
                'public_name' => 'GLOBAL BIOMOLECULAR TECHNOLOGIES (CY) LIMITED',
                'website_url' => 'https://www.craftwill-cwi.com/',
                'description' => '',
                'established_at' => '2022-01-01',
                'tag' => 'GBMT-CY',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'GBMT-CY',
                        'slug' => 'gbmt-cy',
                        'type' => 'Class A',
                        'name' => 'GBMT CY - Class A',
                        'currency' => 'EUR',
                        'price' => 6.4400,
                        'authorized_shares' => 10000000,
                        'outstanding_shares' => 10000000,
                    ],
                ],
            ],
            [
                'name' => 'ReChiffer',
                'public_name' => 'ReChiffer PLC',
                'website_url' => '',
                'description' => '',
                'established_at' => null,
                'tag' => 'CWI',
                'is_active' => true,
                'tickers' => [],
            ],
            [
                'name' => 'Global Trading EXIM',
                'public_name' => 'Global Trading EXIM International PLC',
                'website_url' => '',
                'description' => '',
                'established_at' => '2022-01-01',
                'tag' => 'EXIM',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'EXIM',
                        'slug' => 'exim',
                        'type' => 'Class B',
                        'name' => 'Global Trading EXIM',
                        'currency' => 'EUR',
                        'price' => 1.0000,
                        'authorized_shares' => 1000000000,
                        'outstanding_shares' => 1000000000,
                    ],
                ],
            ],
            [
                'name' => 'REES',
                'public_name' => 'REES Property Active Holding PLC',
                'website_url' => '',
                'description' => '',
                'established_at' => '2020-01-01',
                'tag' => 'REES',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'RPAH-A',
                        'slug' => 'rpah-a',
                        'type' => 'Class A',
                        'name' => 'REES Property - Class-A',
                        'currency' => 'EUR',
                        'price' => 6.8800,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                    [
                        'ticker' => 'RPAH-B',
                        'slug' => 'rpah-b',
                        'type' => 'Class B',
                        'name' => 'REES Property - Class-B',
                        'currency' => 'EUR',
                        'price' => 0.3300,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                    [
                        'ticker' => 'RPAH-C',
                        'slug' => 'rpah-c',
                        'type' => 'Class C',
                        'name' => 'REES Property - Class-C',
                        'currency' => 'EUR',
                        'price' => 0.0000,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                    [
                        'ticker' => 'RPAH-D',
                        'slug' => 'rpah-d',
                        'type' => 'Class D',
                        'name' => 'REES Property - Class-D',
                        'currency' => 'EUR',
                        'price' => 0.0000,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                    [
                        'ticker' => 'RPAH-T',
                        'slug' => 'rpah-t',
                        'type' => 'Token',
                        'name' => 'REES Property - Token',
                        'currency' => 'EUR',
                        'price' => 0.3300,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                ],
            ],
            [
                'name' => 'REES Global Investor ',
                'public_name' => '',
                'website_url' => '',
                'description' => '',
                'established_at' => '2020-01-01',
                'tag' => 'RGI',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'RGI-A',
                        'slug' => 'rgi-a',
                        'type' => 'Class A',
                        'name' => 'REES Global - Class-A',
                        'currency' => 'EUR',
                        'price' => 0.9800,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                    [
                        'ticker' => 'RGI-B',
                        'slug' => 'rgi-b',
                        'type' => 'Class B',
                        'name' => 'REES Global - Class-B',
                        'currency' => 'EUR',
                        'price' => 0.8800,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                ],
            ],
            [
                'name' => 'REES Develoment & Construction',
                'public_name' => '',
                'website_url' => '',
                'description' => '',
                'established_at' => '2020-01-01',
                'tag' => 'REDC',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'REDC-A',
                        'slug' => 'redc-a',
                        'type' => 'Class A',
                        'name' => 'REES D&C - Class-A',
                        'currency' => 'EUR',
                        'price' => 1.0000,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                    [
                        'ticker' => 'REDC-B',
                        'slug' => 'redc-b',
                        'type' => 'Class B',
                        'name' => 'REES D&C - Class-B',
                        'currency' => 'EUR',
                        'price' => 1.0000,
                        'authorized_shares' => 0,
                        'outstanding_shares' => 0,
                    ],
                ],
            ],
            [
                'name' => 'REES Hotels & Resorts',
                'public_name' => '',
                'website_url' => '',
                'description' => '',
                'established_at' => '2020-01-01',
                'tag' => 'RHR',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'RHR',
                        'slug' => 'rhr',
                        'type' => 'A,B',
                        'name' => 'REES Hotel & Resorts - Class-A, Class-B',
                        'currency' => 'EUR',
                        'price' => 3.0000,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                ],
            ],
            [
                'name' => 'the GATE e-Commerce Online Compartment Stores',
                'public_name' => '',
                'website_url' => '',
                'description' => '',
                'established_at' => '2020-01-01',
                'tag' => 'TGOS',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'TGOS',
                        'slug' => 'tgos',
                        'type' => 'Class B',
                        'name' => 'TGI e-Commerce - Class-B',
                        'currency' => 'EUR',
                        'price' => 0.7700,
                        'authorized_shares' => 100000000,
                        'outstanding_shares' => 100000000,
                    ],
                ],
            ],
            [
                'name' => 'Crymonet Financial Merger Services PLC',
                'public_name' => '',
                'website_url' => '',
                'description' => '',
                'established_at' => '2023-01-01',
                'tag' => 'CMFST',
                'is_active' => true,
                'tickers' => [
                    [
                        'ticker' => 'CMFST',
                        'slug' => 'cmfst',
                        'type' => 'Class A',
                        'name' => 'Crymonet Financial Merger Services',
                        'currency' => 'EUR',
                        'price' => 1.0000,
                        'authorized_shares' => 1000000000,
                        'outstanding_shares' => 1000000000,
                    ],
                ],
            ],
        ];

        $i = 1;
        foreach ($projects as $project) {
            $new_project = Project::updateOrCreate(
                [
                    'name' => $project['name'],
                ],
                [
                    'public_name' => $project['public_name'],
                    'website_url' => $project['website_url'],
                    'description' => $project['description'],
                    'established_at' => $project['established_at'],
                    'is_active' => $project['is_active'],
                ]
            );

            if ($project['tag']) {
                $new_project->attachTag($project['tag']);
            }

            if (isset($project['tickers'])) {
                foreach ($project['tickers'] as $ticker) {
                    $currency = Currency::where('code', $ticker['currency'])->first();
                    $ticker_project = Project::where('name', $project['name'])->first();

                    $new_ticker = Ticker::where('ticker', $ticker['ticker'])->first();

                    $product = Product::updateOrCreate(
                        [
                            'name' => $ticker['name'],
                            'currency_id' => $currency->id,
                            'project_id' => $ticker_project->id,
                        ],
                        [
                            'type' => ProductType::Ticker->value,
                            'description' => 'Ticker product for '.$ticker['ticker'],
                            'price' => $ticker['price'],
                        ]
                    );

                    if (! $new_ticker) {
                        $new_ticker = new Ticker();
                        $new_ticker->ticker = $ticker['ticker'];
                        $new_ticker->slug = $ticker['slug'];
                        $new_ticker->type = $ticker['type'];
                        $new_ticker->name = $ticker['name'];
                        $new_ticker->price = $ticker['price'];
                        $new_ticker->authorized_shares = $ticker['authorized_shares'];
                        $new_ticker->outstanding_shares = $ticker['outstanding_shares'];
                    }
                    $new_ticker->project()->associate($ticker_project);
                    $new_ticker->currency()->associate($currency);
                    $new_ticker->product()->associate($product);
                    $new_ticker->save();

                    if (isset($ticker['tag'])) {
                        $new_ticker->attachTag($ticker['tag']);
                    }
                }
            }
            $i++;
        }
    }
}
