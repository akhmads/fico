<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Trading: string implements HasLabel, HasColor
{
    case Export = 'export';
    case Import = 'import';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Export => 'success',
            self::Import => 'info',
        };
    }
}
