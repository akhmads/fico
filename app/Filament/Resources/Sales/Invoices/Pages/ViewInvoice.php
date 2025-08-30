<?php

namespace App\Filament\Resources\Sales\Invoices\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Sales\Invoices\InvoiceResource;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->color('gray')
                ->icon('heroicon-c-arrow-uturn-left')
                ->url($this->getResource()::getUrl('index')),

            Action::make('Approve')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->action(function($action) {

                    Notification::make()
                        ->warning()
                        ->title('You don\'t have an active subscription!')
                        ->body('Choose a plan to continue.')
                        ->persistent()
                        ->actions([
                            Action::make('subscribe')
                                ->button()
                                // ->url(route('subscribe'), shouldOpenInNewTab: true),
                        ])
                        ->send();

                    $action->halt();

                }),

            EditAction::make()
                ->icon('heroicon-c-pencil-square'),
        ];
    }
}
