<?php

namespace App\Models\Sales;

use App\Models\Sales\Invoice\Detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
