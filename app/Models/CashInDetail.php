<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CashInDetail extends Model
{
    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class,'coa_code','code')->withDefault();
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class,'currency_id','id')->withDefault();
    }
}
