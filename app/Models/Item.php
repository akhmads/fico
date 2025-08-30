<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected function casts(): array
    {
        return [
            'type' => \App\Enums\Trading::class,
            'transport' => \App\Enums\Transport::class,
        ];
    }
}
