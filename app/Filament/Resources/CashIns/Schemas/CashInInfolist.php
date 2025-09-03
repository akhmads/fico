<?php

namespace App\Filament\Resources\CashIns\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CashInInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('cashAccount.name'),
                TextEntry::make('contact.name'),
                TextEntry::make('total_amount')
                    ->numeric(),
                TextEntry::make('type'),
                TextEntry::make('note'),
                TextEntry::make('has_receivable')
                    ->numeric(),
                TextEntry::make('used_receivable')
                    ->numeric(),
                TextEntry::make('has_prepaid')
                    ->numeric(),
                TextEntry::make('used_prepaid')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('updated_by')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
