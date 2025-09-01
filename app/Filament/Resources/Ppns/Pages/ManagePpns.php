<?php

namespace App\Filament\Resources\Ppns\Pages;

use App\Filament\Resources\Ppns\PpnResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePpns extends ManageRecords
{
    protected static string $resource = PpnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
