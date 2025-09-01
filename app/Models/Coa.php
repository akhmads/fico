<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    protected $table = 'coa';

    protected function casts(): array
    {
        return [
            'normal_balance' => \App\Enums\DC::class,
            'report_type' => \App\Enums\ReportType::class,
        ];
    }
}
