<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ReportType: string implements HasLabel, HasColor
{
    case BalanceSheet = 'BS';
    case ProfitLoss = 'PL';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BalanceSheet => 'info',
            self::ProfitLoss => 'warning',
        };
    }
}
