<?php

namespace App\Filament\Resources\Sales\Invoices\Schemas;

use App\Helpers\Cast;
use Filament\Support\RawJs;
use App\Enums\InvoiceStatus;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater\TableColumn;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([

                Section::make('Invoice Info')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([

                        TextInput::make('code')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        DatePicker::make('invoice_date')
                            ->default(now())
                            ->required(),
                        TextInput::make('status')
                            ->disabled(fn (string $operation): bool => $operation == 'create' || $operation == 'edit')
                            ->default('open')
                            ->required(),
                    ]),

                TextInput::make('amount')
                    ->disabled()
                    ->required()
                    ->dehydrated(),

                Section::make('Invoice Details')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('details')
                            ->hiddenLabel()
                            ->relationship()
                            ->orderColumn('sort')
                            ->columnSpanFull()
                            ->columns(3)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateTotal($get, $set);
                            })
                            ->deleteAction(function (Action $action) {
                                $action->after(function (Get $get, Set $set) {
                                    self::updateTotal($get, $set);
                                });
                            })
                            ->table([
                                TableColumn::make('Service Charge'),
                                TableColumn::make('Qty')
                                    ->width(100),
                                TableColumn::make('Price')
                                    ->width(200),
                                TableColumn::make('Amount')
                                    ->width(200),
                            ])
                            ->schema([
                                Select::make('item_id')
                                    ->relationship('item','full_name')
                                    ->searchable()
                                    ->preload()
                                    ->optionsLimit(20)
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                                TextInput::make('qty')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->live(debounce:500)
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $val = bcmul( Cast::number($state), Cast::number($get('price')), 2 );
                                        $set('foreign_amount', $val);
                                    }),
                                TextInput::make('price')
                                    ->numeric()
                                    ->inputMode('decimal')
                                    ->required()
                                    ->live(debounce:500)
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $val = bcmul( Cast::number($state), Cast::number($get('qty')), 2 );
                                        $set('foreign_amount', $val);
                                    }),
                                TextInput::make('foreign_amount')
                                    ->disabled()
                                    ->dehydrated()
                                    ->numeric()
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function updateTotal(Get $get, Set $set): void
    {
        // Retrieve all selected products and remove empty rows
        $selectedItems = collect($get('details'))->filter(fn($item) => !empty($item['price']) && !empty($item['qty']));

        // Calculate subtotal based on the selected products and quantities
        $subtotal = $selectedItems->reduce(function ($subtotal, $item) {
            $mul = bcmul(Cast::number($item['price']), Cast::number($item['qty']), 2);
            return bcadd($subtotal, $mul, 2);
        }, 0);

        // Update the state with the new values
        $set('amount', $subtotal);
    }
}
