<?php

namespace App\Filament\Resources\Journals\Pages;

use App\Helpers\Code;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Journals\JournalResource;

class CreateJournal extends CreateRecord
{
    protected static string $resource = JournalResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = Code::auto('JV');
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
