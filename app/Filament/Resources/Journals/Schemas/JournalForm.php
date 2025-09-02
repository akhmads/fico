<?php

namespace App\Filament\Resources\Journals\Schemas;

use App\Enums\DC;
use App\Helpers\Cast;
use App\Enums\JournalType;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater\TableColumn;

class JournalForm
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
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        DatePicker::make('date')
                            ->default(now())
                            ->required(),
                        Select::make('contact_id')
                            ->required()
                            ->relationship('contact','name')
                            ->searchable()
                            ->preload()
                            ->optionsLimit(20),
                            // ->createOptionForm([
                            //     TextInput::make('name')->required(),
                            // ]),
                        TextInput::make('status')
                            ->disabled(fn (string $operation): bool => $operation == 'create' || $operation == 'edit')
                            ->default('open')
                            ->required(),
                        ToggleButtons::make('type')
                            ->inline()
                            ->options(JournalType::class)
                            ->default('general')
                            ->required(),
                        MarkdownEditor::make('note')
                            ->columnSpanFull()
                            ->minHeight('60px'),
                    ]),

                Group::make()
                    ->schema([
                        Section::make('Reference')
                            ->columns(1)
                            ->schema([
                                TextInput::make('journalable_type')
                                    ->label('Reference Type')
                                    ->disabled(),
                                TextInput::make('journalable_id')
                                    ->label('Reference ID')
                                    ->disabled(),
                            ]),

                        Section::make('Total')
                            ->columns(1)
                            ->schema([
                                TextInput::make('debit_total')
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->same('credit_total')
                                    ->formatStateUsing(fn (?string $state): ?string => Cast::money($state))
                                    ->dehydrateStateUsing(fn (?string $state): ?string => Cast::number($state)),
                                TextInput::make('credit_total')
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->formatStateUsing(fn (?string $state): ?string => Cast::money($state))
                                    ->dehydrateStateUsing(fn (?string $state): ?string => Cast::number($state)),
                            ]),
                    ]),

                Section::make('Details')
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
                                TableColumn::make('Account'),
                                TableColumn::make('D/C')
                                    ->width(150),
                                TableColumn::make('Amount')
                                    ->width(200),
                                TableColumn::make('Description'),
                            ])
                            ->schema([
                                Select::make('coa_code')
                                    ->relationship('coa','full_name')
                                    ->searchable()
                                    ->preload()
                                    ->optionsLimit(20)
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                                ToggleButtons::make('dc')
                                    ->grouped()
                                    ->options(DC::class)
                                    ->default('D')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $set('debit', 0);
                                        $set('credit', 0);
                                        self::updateTotal($get, $set);
                                    })
                                    ->required(),
                                Group::make()
                                    ->schema([
                                        TextInput::make('debit')
                                            ->hiddenJs(<<<'JS'
                                                $get('dc') !== 'D'
                                            JS)
                                            ->numeric()
                                            ->default(0)
                                            ->inputMode('decimal')
                                            ->required()
                                            ->live(debounce:500)
                                            ->afterStateUpdated(function (Get $get, Set $set) {
                                                self::updateTotal($get, $set);
                                            }),
                                        TextInput::make('credit')
                                            ->hiddenJs(<<<'JS'
                                                $get('dc') !== 'C'
                                            JS)
                                            ->numeric()
                                            ->default(0)
                                            ->inputMode('decimal')
                                            ->required()
                                            ->live(debounce:500)
                                            ->afterStateUpdated(function (Get $get, Set $set) {
                                                self::updateTotal($get, $set);
                                            }),
                                    ]),
                                TextInput::make('description')
                                    ->required(),
                            ]),
                    ]),

            ]);
    }

    public static function updateTotal(Get $get, Set $set): void
    {
        // $selectedItems = collect($get('details'))->filter(fn($item) => !empty($item['debit']) && !empty($item['credit']));
        // $subtotal = $selectedItems->reduce(function ($subtotal, $item) {
        //     $mul = bcmul(Cast::number($item['price']), Cast::number($item['qty']), 2);
        //     return bcadd($subtotal, $mul, 2);
        // }, 0);

        $selectedItems = collect($get('details'));

        $debit_total = $selectedItems->reduce(function ($debit_total, $item) {
            return bcadd($debit_total, Cast::number($item['debit']), 2);
        }, 0);

        $credit_total = $selectedItems->reduce(function ($credit_total, $item) {
            return bcadd($credit_total, Cast::number($item['credit']), 2);
        }, 0);

        $set('debit_total', Cast::money($debit_total));
        $set('credit_total', Cast::money($credit_total));

        // $set('debit_total', Cast::money($selectedItems->sum('debit')));
        // $set('credit_total', Cast::money($selectedItems->sum('credit')));
    }
}
