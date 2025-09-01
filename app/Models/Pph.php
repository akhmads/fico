<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pph extends Model
{
    protected $table = 'pph';

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
        ];
    }
}
