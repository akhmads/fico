<?php

namespace App\Filament\Resources\Uoms\Pages;

use App\Filament\Resources\Uoms\UomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageUoms extends ManageRecords
{
    protected static string $resource = UomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Uom'),
        ];
    }
}
