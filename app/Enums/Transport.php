<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Transport: string implements HasLabel, HasColor
{
    case All = 'all';
    case Air = 'air';
    case Sea = 'sea';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::All => 'success',
            self::Air => 'primary',
            self::Sea => 'info',
        };
    }
}
