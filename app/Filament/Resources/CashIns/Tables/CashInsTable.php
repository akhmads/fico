<?php

namespace App\Filament\Resources\CashIns\Tables;

use App\Enums\Approval;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\Width;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\RecordActionsPosition;

class CashInsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->filtersFormWidth(Width::ExtraLarge)
            ->filtersFormMaxHeight('400px')
            ->filtersFormColumns(2)
            ->defaultSort('created_at','desc')
            ->columns([
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('cashAccount.name')
                    ->searchable(),
                TextColumn::make('contact.name')
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->numeric(decimalPlaces: 0)
                    ->sortable(),
                TextColumn::make('type'),
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
                Filter::make('date')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        DatePicker::make('date1')->label('From')->default(Carbon::now()->subDays(30)),
                        DatePicker::make('date2')->label('To')->default(Carbon::now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date1'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['date2'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
                SelectFilter::make('status')
                    ->options(Approval::class),
            ])
            ->recordActions([
                    ActionGroup::make([
                        ViewAction::make(),
                        EditAction::make(),
                    ])
                    ->dropdownPlacement('bottom-start'),
                ],
                position: RecordActionsPosition::BeforeColumns
            )
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
