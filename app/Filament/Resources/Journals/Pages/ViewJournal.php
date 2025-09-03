<?php

namespace App\Filament\Resources\Journals\Pages;

use App\Models\Journal;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
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

            Action::make('Approve')
                // ->visible(fn (Journal $record) => $record->status->value == 'open')
                ->authorize('approve')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->action(function(Journal $record) {

                    $this->record->update([
                        'status' => 'approved'
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Success')
                        ->body('Journal successfully approved.')
                        ->persistent()
                        ->send();
                }),

            EditAction::make()
                ->icon('heroicon-c-pencil-square'),
        ];
    }
}
