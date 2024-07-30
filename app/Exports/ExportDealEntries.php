<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportDealEntries implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings
{
    private $deal_id;

    public function __construct($deal_id)
    {
        $this->deal_id = $deal_id;
    }

    public function collection()
    {
        $deal_entries = DB::table('deal_entries')
            ->select(
                DB::raw('GROUP_CONCAT(roles.name) AS role'),
                'users.firstname',
                'users.middlename',
                'users.lastname',
                'deal_entries.dealable_quantity',
                'deal_entries.billable_price',
                'deal_entries.billable_quantity',
                'invoices.invoice_number',
                'invoices.invoice_date',
                'currencies.name as currency',
                DB::raw('SUM(invoice_products.price)'),
                DB::raw('invoice_products.price - COALESCE(SUM(invoice_payments.amount), 0) AS invoice_balance'),
                'invoices.status'
            )
            ->leftJoin('deals', 'deals.id', '=', 'deal_entries.deal_id')
            ->leftJoin('users', 'users.id', '=', 'deal_entries.user_id')
            ->leftJoin('invoices', 'invoices.id', '=', 'deal_entries.invoice_id')
            ->leftJoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->leftJoin('invoice_products', 'invoice_products.invoice_id', '=', 'invoices.id')
            ->leftJoin('invoice_payments', 'invoice_payments.invoice_id', '=', 'invoices.id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('deal_entries.deal_id', $this->deal_id)
            ->groupBy(
                'users.firstname',
                'users.middlename',
                'users.lastname',
                'deal_entries.dealable_quantity',
                'deal_entries.billable_price',
                'deal_entries.billable_quantity',
                'invoice_products.price',
                'invoices.invoice_number',
                'invoices.invoice_date',
                'currencies.name',
                'invoices.status'
            )
            ->get();

        return $deal_entries;
    }

    public function headings(): array
    {
        return [
            'role',
            'first_name',
            'middle_name',
            'last_name',
            'dealable_quantity',
            'billable_price',
            'billable_quantity',
            'invoice_number',
            'invoice_date',
            'currency',
            'invoice_total',
            'invoice_balance',
            'invoice_status',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_ACCOUNTING_EUR,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J' => NumberFormat::FORMAT_ACCOUNTING_EUR,
            'K' => NumberFormat::FORMAT_ACCOUNTING_EUR,
        ];
    }
}
