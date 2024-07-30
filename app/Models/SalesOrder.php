<?php

namespace App\Models;

use App\Enum\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'customer_id',
        'invoice_id',
        'language_id',
        'currency_id',
        'template_id',
        'status',
        'order_number',
        'order_date',
        'note',
        'reference',
    ];

    protected static function booted(): void
    {
        static::saving(function ($salesOrder): void {
            if ($salesOrder->status != Status::Draft->value) {
                $meta = ProjectMeta::where('project_id', $salesOrder->project_id)
                    ->whereIn('field', ['sales-order-prefix', 'sales-order-series'])
                    ->get()
                    ->pluck('value', 'field');

                if (count($meta) == 0) {
                    $lastSalesOrder = SalesOrder::where('order_number', 'like', config('defaults.sales-order-prefix').'%')
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($lastSalesOrder) {
                        $lastOrderNumber = $lastSalesOrder->order_number;
                        $number = str_replace(config('defaults.sales-order-prefix'), '', $lastOrderNumber);
                        $salesOrder->order_number = config('defaults.sales-order-prefix').intval($number) + 1;
                    } else {
                        $prefix = config('defaults.sales-order-prefix');
                        $initialSeries = config('defaults.sales-order-series');
                        $salesOrder->order_number = $prefix.intval($initialSeries) + 1;
                    }
                } else {
                    $lastInvoiceNumber = SalesOrder::where('order_number', 'like', $meta['sales-order-prefix'].'%')
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($lastInvoiceNumber) {
                        $lastOrderNumber = $lastInvoiceNumber->order_number;
                        $lastNumber = str_replace($meta['sales-order-prefix'], '', $lastOrderNumber);
                        $salesOrder->order_number = $meta['sales-order-prefix'].intval($lastNumber) + 1;
                    } else {
                        $metaPrefix = $meta['sales-order-prefix'];
                        $metaInitialSeries = $meta['sales-order-series'];
                        $salesOrder->order_number = $metaPrefix.intval($metaInitialSeries) + 1;
                    }
                }
            }
        });
    }

    public function calculateTotalGross()
    {
        $totalGross = 0;

        foreach ($this->sales_order_products as $item) {
            $totalGross += ($item->price - $item->discount) * $item->quantity;
        }

        return $totalGross;
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'payable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sales_order_products(): HasMany
    {
        return $this->hasMany(SalesOrderProduct::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
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
}
