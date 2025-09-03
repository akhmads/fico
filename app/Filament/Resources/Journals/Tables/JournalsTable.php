<?php

namespace App\Filament\Resources\Journals\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class JournalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->filtersFormWidth(Width::ExtraLarge)
            ->filtersFormMaxHeight('400px')
            ->filtersFormColumns(2)
            ->columns([
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('debit_total')
                    ->money('IDR', decimalPlaces: 2),
                TextColumn::make('credit_total')
                    ->money('IDR', decimalPlaces: 2),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
