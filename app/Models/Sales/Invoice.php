<?php

namespace App\Models\Sales;

use App\Models\Sales\Invoice\Detail;
use App\Policies\SalesInvoicePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(SalesInvoicePolicy::class)]
class Invoice extends Model
{
    protected $table = 'sales_invoices';

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\InvoiceStatus::class,
        ];
    }

    public function details(): HasMany
	{
		return $this->hasMany(Detail::class,'sales_invoice_id','id');
	}
}
