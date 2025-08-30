<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InvoiceStatus: string implements HasLabel, HasColor
{
    case Open = 'open';
    case Approved = 'approved';
    case Void = 'void';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Open => 'primary',
            self::Approved => 'success',
            self::Void => 'danger',
        };
    }
}
