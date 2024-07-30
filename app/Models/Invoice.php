<?php

namespace App\Models;

use App\Enum\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'customer_id',
        'currency_id',
        'language_id',
        'template_id',
        'status',
        'invoice_number',
        'invoice_date',
        'due_date',
        'sent_at',
        'note',
        'reference',
    ];

    protected static function booted(): void
    {
        static::saving(function ($invoice): void {
            if ($invoice->status === Status::Pending->value) {
                $project_id = $invoice->project_id;
                $meta = ProjectMeta::where('project_id', $project_id)
                    ->whereIn('field', ['invoice-prefix', 'invoice-series'])
                    ->get()
                    ->pluck('value', 'field');

                if (! $project_id || $meta->isEmpty()) {
                    $latestTGWInvoice = self::where('invoice_number', 'like', config('defaults.invoice-prefix').'%')
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($latestTGWInvoice) {
                        $lastDashPosition = strrpos($latestTGWInvoice->invoice_number, '-');
                        $prefix = substr($latestTGWInvoice->invoice_number, 0, $lastDashPosition + 1);
                        $numericPart = intval(substr($latestTGWInvoice->invoice_number, $lastDashPosition + 1)) + 1;
                        $invoice->invoice_number = $prefix.str_pad($numericPart, 5, '0', STR_PAD_LEFT);
                    } else {
                        $prefix = config('defaults.invoice-prefix');
                        $initialSeries = config('defaults.invoice-series');
                        $invoice->invoice_number = $prefix.intval($initialSeries) + 1;
                    }
                } else {
                    $latestInvoiceNumber = self::where('invoice_number', 'like', $meta['invoice-prefix'].'%')
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($latestInvoiceNumber) {
                        $lastDashPosition = strrpos($latestInvoiceNumber->invoice_number, '-');
                        $prefix = substr($latestInvoiceNumber->invoice_number, 0, $lastDashPosition + 1);
                        $numericPart = intval(substr($latestInvoiceNumber->invoice_number, $lastDashPosition + 1)) + 1;
                        $invoice->invoice_number = $prefix.str_pad($numericPart, 5, '0', STR_PAD_LEFT);
                    } else {
                        $invoice->invoice_number = $meta['invoice-prefix'].intval($meta['invoice-series']) + 1;
                    }
                }
            }
        });
    }

    public function calculateTotalGross()
    {
        $totalGross = 0;

        foreach ($this->invoice_products as $item) {
            $totalGross += ($item->price - $item->discount) * $item->quantity;
        }

        return $totalGross;
    }

    public function getBalanceAttribute()
    {
        $payments = InvoicePayment::where('invoice_id', $this->id)->sum('amount');

        if ($payments) {
            return number_format($this->calculateTotalGross() - $payments, 2, '.', ',');
        }

        return number_format($this->calculateTotalGross(), 4, '.', ',');
    }

    public function sales_order()
    {
        return SalesOrder::where('invoice_id', $this->id)->first();
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(PdfTemplate::class);
    }

    public function invoice_products(): HasMany
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function email_templates(): HasMany
    {
        return $this->hasMany(EmailTemplate::class);
    }

    public function invoice_payments(): HasMany
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function deal_entry(): HasOne
    {
        return $this->hasOne(DealEntry::class);
    }
}
