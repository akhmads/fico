<?php

namespace App\Filament\Resources\CashIns\Pages;

use App\Filament\Resources\CashIns\CashInResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCashIn extends ViewRecord
{
    protected static string $resource = CashInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
