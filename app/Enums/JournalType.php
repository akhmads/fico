<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JournalType: string implements HasLabel, HasColor
{
    case General = 'general';
    case Adjustment = 'adjustment';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::General => 'info',
            self::Adjustment => 'warning',
        };
    }
}
