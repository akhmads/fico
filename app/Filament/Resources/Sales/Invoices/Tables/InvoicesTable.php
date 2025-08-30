<?php

namespace App\Filament\Resources\Sales\Invoices\Tables;

use Filament\Tables\Table;
use App\Enums\InvoiceStatus;
use Filament\Actions\Action;
use App\Models\Sales\Invoice;
use Illuminate\Support\Carbon;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\Width;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Enums\RecordActionsPosition;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('invoice_date')
                    ->date()
                    ->searchable(),
                TextColumn::make('amount')
                    ->money('IDR', decimalPlaces: 2),
            ])
            ->persistFiltersInSession()
            ->filtersFormWidth(Width::ExtraLarge)
            ->filtersFormMaxHeight('400px')
            ->filtersFormColumns(2)
            ->filters([
                Filter::make('created_at')
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
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['date2'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                SelectFilter::make('status')
                    ->options(InvoiceStatus::class),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()
                        ->visible(fn (Invoice $record) => $record->status->value == 'open'),
                    // Action::make('Approve')
                    //     ->requiresConfirmation()
                    //     ->action(fn (Invoice $record) => dd($record))
                    //     ->visible(fn (Invoice $record) => $record->status->value == 'open'),
                ])
                ->dropdownPlacement('bottom-start'),
                ],
                position: RecordActionsPosition::BeforeColumns
            )
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    // BulkAction::make('Approve')
                    //     ->requiresConfirmation()
                    //     ->action(function(Collection $records){
                    //         dd($records->toArray());
                    //     }),
                ]),
            ]);
    }
}
