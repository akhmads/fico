<?php

namespace App\Filament\Pages;

use UnitEnum;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs\Tab;

class Settings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected string $view = 'filament.pages.settings';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return true;
    }

    public function mount(): void
    {
        $this->form->fill([
            'journal_code' => settings('journal_code'),
            'cash_in_code' => settings('cash_in_code'),
            'cash_out_code' => settings('cash_out_code'),
            'bank_in_code' => settings('bank_in_code'),
            'bank_out_code' => settings('bank_out_code'),
            'intercash_code' => settings('intercash_code'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Code')
                            ->icon(Heroicon::Hashtag)
                            ->columns(1)
                            ->schema([

                                Fieldset::make('Cash And Bank')
                                    ->columns(['xl' => 5])
                                    ->schema([
                                        TextInput::make('cash_in_code')
                                            ->label('Cash In')
                                            ->required()
                                            ->maxLength(20),
                                        TextInput::make('cash_out_code')
                                            ->label('Cash Out')
                                            ->required()
                                            ->maxLength(20),
                                        TextInput::make('bank_in_code')
                                            ->label('Bank In')
                                            ->required()
                                            ->maxLength(20),
                                        TextInput::make('bank_out_code')
                                            ->label('Bank Out')
                                            ->required()
                                            ->maxLength(20),
                                        TextInput::make('intercash_code')
                                            ->label('Intercash')
                                            ->required()
                                            ->maxLength(20),
                                    ]),

                                Fieldset::make('General Ledger')
                                    ->columns(['xl' => 5])
                                    ->schema([
                                        TextInput::make('journal_code')
                                            ->label('Journal')
                                            ->required()
                                            ->maxLength(20),
                                    ]),

                            ]),
                        Tab::make('Tab 2')
                            ->schema([
                                // ...
                            ]),
                    ]),
            ])
            // ->record($this->getRecord())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        settings($data);

        Notification::make()
            ->success()
            ->title('Saved.')
            ->send();
    }
}
