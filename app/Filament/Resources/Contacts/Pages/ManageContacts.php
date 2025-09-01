<?php

namespace App\Filament\Resources\Contacts\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use App\Filament\Exports\ContactExporter;
use App\Filament\Imports\ContactImporter;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Contacts\ContactResource;

class ManageContacts extends ManageRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->label('Import')
                ->importer(ContactImporter::class),
            ExportAction::make()
                ->label('Export')
                ->exporter(ContactExporter::class),
            CreateAction::make(),
        ];
    }
}
