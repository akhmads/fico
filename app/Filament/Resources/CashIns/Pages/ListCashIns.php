<?php

namespace App\Filament\Resources\CashIns\Pages;

use App\Filament\Resources\CashIns\CashInResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCashIns extends ListRecords
{
    protected static string $resource = CashInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
