<?php

namespace App\Models\Sales\Invoice;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detail extends Model
{
    protected $table = 'sales_invoice_details';

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
