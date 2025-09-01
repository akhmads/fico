<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DC: string implements HasLabel, HasColor
{
    case Debit = 'D';
    case Credit = 'C';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Debit => 'success',
            self::Credit => 'danger',
        };
    }
}
