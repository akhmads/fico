<?php

namespace App\Filament\Resources\Sales\Invoices\Pages;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Sales\Invoices\InvoiceResource;

class EditInvoice extends EditRecord
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

    protected function getFormActions(): array
    {
        return [
            // $this->getCreateFormAction(),
            // (static::canCreateAnother() ? $this->getCreateAnotherFormAction() : null),

            $this->getSaveFormAction(),
            // $this->getCancelFormAction(),

            Action::make('Cancel')
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
        ];
    }

    protected function afterSave(): void
    {
        //$this->getRecord();
    }
}
