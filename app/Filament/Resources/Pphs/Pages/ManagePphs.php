<?php

namespace App\Filament\Resources\Pphs\Pages;

use App\Filament\Resources\Pphs\PphResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePphs extends ManageRecords
{
    protected static string $resource = PphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
