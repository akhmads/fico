<?php

namespace App\Filament\Resources\Journals\Pages;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Journals\JournalResource;

class EditJournal extends EditRecord
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

            ViewAction::make()
                ->icon('heroicon-c-eye'),

            DeleteAction::make()
                ->icon('heroicon-o-trash'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
