<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected function casts(): array
    {
        return [
            'type' => \App\Enums\Trading::class,
            'transport' => \App\Enums\Transport::class,
        ];
    }
}
