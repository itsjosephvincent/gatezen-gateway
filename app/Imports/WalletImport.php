<?php

namespace App\Imports;

use App\Mail\WalletImportSummaryEmail;
use App\Models\Ticker;
use App\Models\User;
use App\Services\ExchangeService;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class WalletImport implements ToCollection, WithHeadingRow
{
    protected $exchangeService;

    public function __construct()
    {
        $this->exchangeService = new ExchangeService();
    }

    public function collection(Collection $rows): void
    {
        $successfulTransactions = [];
        $failedTransactions = [];
        $adminUser = auth()->user();

        foreach ($rows as $row) {
            $ticker = Ticker::where('ticker', $row['type'])->first();
            $user = User::where('email', $row['email'])->first();

            $money = str_replace([' ', ',', "\xc2\xa0"], ['', '.', ''], $row['amount']);
            $amount = preg_replace('/[^0-9.]/', '', $money);

            $shares = str_replace(',', '.', $row['shares']);
            $shares = preg_replace('/[^0-9.]/', '', $shares);

            if ($ticker && $user) {
                if ($amount > 0 || $shares > 0) {
                    try {
                        if (! $shares) {
                            $shares = $amount / $ticker->price;
                        }
                        $data = [
                            'ticker' => [
                                $ticker->id,
                            ],
                            'shares' => $shares,
                            'description' => $row['description'],
                        ];

                        // Validate date row
                        if ($row['date'] && (DateTime::createFromFormat('d.m.y', $row['date']) !== false)) {
                            $data['transaction_date'] = DateTime::createFromFormat('d.m.y', $row['date'])->format('Y-m-d H:i:s');
                        }

                        $this->exchangeService->buy($user, $data);
                        $successfulTransactions[] = ['data' => $row];
                    } catch (Throwable $e) {
                        $failedTransactions[] = [
                            'data' => $row,
                            'error' => $e->getMessage(),
                        ];
                    }
                } else {
                    $failedTransactions[] = [
                        'data' => $row,
                        'error' => 'Error in amount or shares.',
                    ];
                }
            } else {
                $failedTransactions[] = [
                    'data' => $row,
                    'error' => 'No ticker/user found in the database.',
                ];
            }
        }
        Mail::to($adminUser->email)
            ->send(new WalletImportSummaryEmail($successfulTransactions, $adminUser, $failedTransactions));
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
        ];
    }
}
