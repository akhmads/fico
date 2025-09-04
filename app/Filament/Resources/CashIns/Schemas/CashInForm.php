<?php

namespace App\Filament\Resources\CashIns\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class CashInForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Journal Info')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([

                        TextInput::make('code')
                            ->disabled()
                            ->placeholder('[auto]')
                            ->unique(ignoreRecord: true),
                        DatePicker::make('date')
                            ->default(now()),
                        Select::make('cash_account_id')
                            ->required()
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->relationship('cashAccount', 'name', fn (Builder $query) => $query->where('is_active','1'))
                            ->searchable()
                            ->preload()
                            ->optionsLimit(20),
                        Select::make('contact_id')
                            ->required()
                            ->relationship('contact', 'name', fn (Builder $query) => $query->where('is_active','1'))
                            ->searchable()
                            ->preload()
                            ->optionsLimit(20),
                        TextInput::make('total_amount')
                            ->required()
                            ->numeric()
                            ->default(0.0),
                        TextInput::make('type'),
                        TextInput::make('note'),
                        TextInput::make('status')
                            ->disabled()
                            ->default('open')
                            ->required(),
                    ]),
            ]);
    }
}
