<?php

namespace App\Filament\Resources\CashIns\Pages;

use App\Filament\Resources\CashIns\CashInResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCashIn extends EditRecord
{
    protected static string $resource = CashInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
