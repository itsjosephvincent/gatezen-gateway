<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportInvoices implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings
{
    public function collection()
    {
        return DB::table('invoices')
            ->select(
                'invoices.id',
                'invoices.invoice_number',
                'invoices.invoice_date',
                'invoices.due_date',
                'invoices.status',
                'projects.name',
                'users.firstname',
                'users.middlename',
                'users.lastname',
                'currencies.name as currency',
                'languages.name as language',
                'invoices.reference',
                'invoice_products.product_name',
                'invoice_products.description',
                'invoice_products.quantity',
                'invoice_products.price',
                DB::raw('SUM(invoice_products.price) as total'),
                DB::raw('COALESCE(SUM(invoice_payments.amount), 0) as payment'),
                DB::raw('(SUM(invoice_products.price) - COALESCE(SUM(invoice_payments.amount), 0)) as balance')
            )
            ->leftJoin('projects', 'projects.id', '=', 'invoices.project_id')
            ->leftJoin('users', 'users.id', '=', 'invoices.customer_id')
            ->leftJoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->leftJoin('languages', 'languages.id', '=', 'invoices.language_id')
            ->leftJoin('invoice_products', 'invoice_products.invoice_id', '=', 'invoices.id')
            ->leftJoin('invoice_payments', 'invoice_payments.invoice_id', '=', 'invoices.id')
            ->groupBy(
                'invoices.id',
                'invoices.invoice_number',
                'invoices.invoice_date',
                'invoices.due_date',
                'invoices.status',
                'projects.name',
                'users.firstname',
                'users.middlename',
                'users.lastname',
                'currency',
                'language',
                'invoices.reference',
                'invoice_products.product_name',
                'invoice_products.description',
                'invoice_products.quantity',
                'invoice_products.price',
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'invoice_number',
            'invoice_date',
            'due_date',
            'status',
            'project_name',
            'customer_firstname',
            'customer_middlename',
            'customer_lastname',
            'currency',
            'language',
            'reference',
            'product_name',
            'description',
            'quantity',
            'price',
            'total',
            'payments',
            'balance',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_NUMBER,
            'P' => NumberFormat::FORMAT_ACCOUNTING_EUR,
            'Q' => NumberFormat::FORMAT_ACCOUNTING_EUR,
            'R' => NumberFormat::FORMAT_ACCOUNTING_EUR,
            'S' => NumberFormat::FORMAT_ACCOUNTING_EUR,
        ];
    }
}
