<?php

namespace App\Filament\Resources\Journals\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Journals\JournalResource;

class ViewJournal extends ViewRecord
{
    protected static string $resource = JournalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->color('gray')
                ->icon('heroicon-c-arrow-uturn-left')
                ->url($this->getResource()::getUrl('index')),

            EditAction::make()
                ->icon('heroicon-c-pencil-square'),
        ];
    }
}
