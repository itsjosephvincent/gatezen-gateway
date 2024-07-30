<?php

namespace Database\Seeders;

use App\Models\Ticker;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserDealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_array = [
            [
                'firstname' => 'Anbjørn',
                'lastname' => 'Tronerud',
                'email' => 'ahtronerud@gmail.com',
                'ticker' => 'ODDSPROFITT',
                'amount' => 1035.16,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Alf Marlon',
                'lastname' => 'Bø',
                'email' => 'almarlon@online.no',
                'ticker' => 'ODDSPROFITT',
                'amount' => 1777.34,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Fred',
                'lastname' => 'Thorkildsen',
                'email' => 'fredthorkildsen@gmail.com',
                'ticker' => 'ODDSPROFITT',
                'amount' => 1035.16,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Kristoffer',
                'lastname' => 'Skjørestad',
                'email' => 'kristoffer.skjorestad@lyse.net',
                'ticker' => 'ODDSPROFITT',
                'amount' => 9960.94,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Kurt Mikkelsen',
                'lastname' => 'Skjørestad',
                'email' => 'kurt.skjorestad@lyse.net',
                'ticker' => 'ODDSPROFITT',
                'amount' => 3984.38,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Ørjan',
                'lastname' => 'Holmen',
                'email' => 'oerjan3@hotmail.com',
                'ticker' => 'ODDSPROFITT',
                'amount' => 2070.31,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Ole',
                'lastname' => 'Selvær',
                'email' => 'oleselvaer@gmail.com',
                'ticker' => 'ODDSPROFITT',
                'amount' => 3515.63,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Unni',
                'lastname' => 'Warren',
                'email' => 'unni@warr1.no',
                'ticker' => 'ODDSPROFITT',
                'amount' => 6269.53,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'John Emil',
                'lastname' => 'Skjørestad',
                'email' => 'john.emil.skjorestad@lyse.net',
                'ticker' => 'ODDSPROFITT',
                'amount' => 2937.11,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Else',
                'lastname' => 'Skjørestad',
                'email' => 'steinerikwarren@gmail.com', // Merge with steinerikwarren@gmail.com
                'ticker' => 'ODDSPROFITT',
                'amount' => 4140.63,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Stein Erik',
                'lastname' => 'Warren',
                'email' => 'steinerikwarren@gmail.com',
                'ticker' => 'ODDSPROFITT',
                'amount' => 12500.00,
                'description' => 'Oddsprofitt deal',
            ],
            [
                'firstname' => 'Gunn',
                'lastname' => 'Egeland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 10742.19,
                'invoice_number' => '',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Arnfinn',
                'lastname' => 'Tøresby',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 34869.92,
                'invoice_number' => 'PD7195',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Roy',
                'lastname' => 'Tjemsland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 11407.42,
                'invoice_number' => 'PD7196',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Aina',
                'lastname' => 'Løland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 13001.37,
                'invoice_number' => 'PD7197',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Rafoss',
                'lastname' => 'Investering AS',
                'email' => 'thor@stavangerhytten.no',
                'ticker' => 'THESIS',
                'amount' => 9765.63,
                'invoice_number' => 'PD7198',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Gunnar',
                'lastname' => 'Fidjeland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 48828.13,
                'invoice_number' => 'PD7199',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Kristian Vatne',
                'lastname' => 'Upsaker',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 19531.25,
                'invoice_number' => 'PD7200',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Magnar',
                'lastname' => 'Sigland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 19531.25,
                'invoice_number' => 'PD7201',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Stein Roald',
                'lastname' => 'Levang',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 25848.83,
                'invoice_number' => 'PD7202',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Nina',
                'lastname' => 'Håvarstein',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 7352.15,
                'invoice_number' => 'PD7203',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Eirik',
                'lastname' => 'Håvarstein',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 35743.75,
                'invoice_number' => 'PD7204',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Geir Magne',
                'lastname' => 'Omtveit',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 32896.48,
                'invoice_number' => 'PD7205',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Ivar',
                'lastname' => 'Jonassen',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 24414.06,
                'invoice_number' => 'PD7206',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Torfinn',
                'lastname' => 'Nesset',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 9765.63,
                'invoice_number' => 'PD7207',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Tore',
                'lastname' => 'Malmai',
                'email' => 'tore@malmei.no',
                'ticker' => 'THESIS',
                'amount' => 15069.53,
                'invoice_number' => 'PD7208',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Tore',
                'lastname' => 'Scheffler',
                'email' => 'toresc@gmail.com',
                'ticker' => 'THESIS',
                'amount' => 6618.55,
                'invoice_number' => 'PD7209',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Brian',
                'lastname' => 'Christensen',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 9023.43,
                'invoice_number' => 'PD7222',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Torbjørn',
                'lastname' => 'Skaar',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 19531.25,
                'invoice_number' => 'PD7223',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Anne',
                'lastname' => 'Jonassen Johnsen',
                'email' => 'ivjon1@outlook.com',
                'ticker' => 'THESIS',
                'amount' => 4882.81,
                'invoice_number' => 'PD7226',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Bjørn Ivar',
                'lastname' => 'Jonassen Johnsen',
                'email' => 'jonassen_1@hotmail.com',
                'ticker' => 'THESIS',
                'amount' => 9765.63,
                'invoice_number' => 'PD7227',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Lars',
                'lastname' => 'Engelsvoll',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 23709.96,
                'invoice_number' => 'PD7210',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'CB',
                'lastname' => 'Holding AS',
                'email' => 'cb@novaform.no',
                'ticker' => 'THESIS',
                'amount' => 11691.21,
                'invoice_number' => 'PD7211',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Odd Kolbjørn',
                'lastname' => 'Michelson',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 42745.12,
                'invoice_number' => 'PD7212',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Tor Oddvar',
                'lastname' => 'Rosland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 13611.13,
                'invoice_number' => 'PD7213',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Olaf',
                'lastname' => 'Rosland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 6572.66,
                'invoice_number' => 'PD7214',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Arnt Ove',
                'lastname' => 'Engelsvold',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 26371.09,
                'invoice_number' => 'PD7215',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Erling',
                'lastname' => 'Grøsfjell',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 9765.63,
                'invoice_number' => 'PD7216',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Vaule',
                'lastname' => 'Eiendom AS',
                'email' => 'elivaule@lyse.net',
                'ticker' => 'THESIS',
                'amount' => 73154.88,
                'invoice_number' => 'PD7217',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Arve',
                'lastname' => 'Hogstad',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 10525.78,
                'invoice_number' => 'PD7218',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Nils Magne',
                'lastname' => 'Ørestrand',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 6630.08,
                'invoice_number' => 'PD7219',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Sindre',
                'lastname' => 'Ånestad',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 39062.50,
                'invoice_number' => '',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Anne Margrethe',
                'lastname' => 'Egeland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 10725.00,
                'invoice_number' => '',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Asbjørn',
                'lastname' => 'Skåland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 2343.75,
                'invoice_number' => 'PD7220',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Torkel Magne',
                'lastname' => 'Liland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 9765.63,
                'invoice_number' => 'PD7221',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Frode',
                'lastname' => 'Fatland',
                'email' => '',
                'ticker' => 'THESIS',
                'amount' => 12847.46,
                'invoice_number' => 'PD7224',
                'description' => 'Thesis deal',
            ],
            [
                'firstname' => 'Trond',
                'lastname' => 'Rygg',
                'email' => 'trond@rogm.no',
                'ticker' => 'THESIS',
                'amount' => 14433.20,
                'invoice_number' => 'PD7225',
                'description' => 'Thesis deal',
            ],
        ];

        foreach ($user_array as $user_data) {
            $user = User::where('email', $user_data['email'])->first();

            if (! $user) {
                $user = User::where('firstname', $user_data['firstname'])->where('lastname', $user_data['lastname'])->first();
            }

            if (! $user && ! empty($user_data['email'])) {
                $user = new User();
                $user->firstname = trim($user_data['firstname']);
                $user->lastname = trim($user_data['lastname']);
                $user->email = strtolower($user_data['email']);
                $user->password = Hash::make(Str::random(12));
                $user->save();
            }

            if (! $user) {
                Log::info('User not found nor created:'.json_encode($user_data));

                continue;
            }

            $ticker = Ticker::where('ticker', $user_data['ticker'])->first();

            if ($user && $ticker) {
                $user->attachTags($ticker->tags->pluck('name'));

                $wallet = Wallet::with(['belongable'])
                    ->where('holdable_type', get_class($user))
                    ->where('holdable_id', $user->id)
                    ->where('belongable_type', get_class($ticker))
                    ->where('belongable_id', $ticker->id)
                    ->first();

                if (! $wallet) {
                    $wallet = new Wallet();
                    $wallet->holdable_type = get_class($user);
                    $wallet->holdable_id = $user->id;
                    $wallet->belongable_type = get_class($ticker);
                    $wallet->belongable_id = $ticker->id;
                    $wallet->slug = Str::slug($ticker->ticker);
                    $wallet->balance = $user_data['amount'];
                    $wallet->save();
                }

                $transaction = new Transaction();
                $transaction->payable_type = get_class($ticker);
                $transaction->payable_id = $ticker->id;
                $transaction->wallet_id = $wallet->id;
                $transaction->amount = number_format($user_data['amount'], 4, '.', '');
                $transaction->is_pending = 0;
                $transaction->transaction_type = 'Bought';
                $transaction->description = $user_data['description'];
                $transaction->created_at = '2023-10-01 00:00:00';
                $transaction->save();
            }
        }
    }
}
