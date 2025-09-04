<?php

namespace App\Filament\Resources\CashIns\Pages;

use App\Filament\Resources\CashIns\CashInResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCashIn extends CreateRecord
{
    protected static string $resource = CashInResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $cashAccount = CashAccount::find($data['cash_account_id']);
        // $prefix = settings('cash_in_code') . $cashAccount->code;

        $prefix = 'BKM-' . $cashAccount->code;
        $data['code'] = Code::auto($prefix, $data['date']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
