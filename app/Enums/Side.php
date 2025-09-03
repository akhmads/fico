<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Side: string implements HasLabel, HasColor
{
    case DB = 'D';
    case CR = 'C';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DB => 'success',
            self::CR => 'danger',
        };
    }
}
