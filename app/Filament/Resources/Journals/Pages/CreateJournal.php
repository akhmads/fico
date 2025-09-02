<?php

namespace App\Filament\Resources\Journals\Pages;

use App\Filament\Resources\Journals\JournalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJournal extends CreateRecord
{
    protected static string $resource = JournalResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $data['debit_total'] = '1000';
        return $data;
    }
}
