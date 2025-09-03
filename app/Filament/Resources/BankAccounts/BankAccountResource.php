<?php

namespace App\Filament\Resources\BankAccounts;

use UnitEnum;
use Filament\Tables\Table;
use App\Models\BankAccount;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BankAccounts\Pages\ManageBankAccounts;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static string|UnitEnum|null $navigationGroup = 'Master';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('bank_id')
                    ->relationship('bank', 'name', fn (Builder $query) => $query->where('is_active','1'))
                    ->searchable()
                    ->preload()
                    ->optionsLimit(20)
                    ->required(),
                Select::make('currency_id')
                    ->relationship('currency', 'name', fn (Builder $query) => $query->where('is_active','1'))
                    ->searchable()
                    ->preload()
                    ->optionsLimit(20)
                    ->required(),
                Select::make('coa_code')
                    ->relationship('coa', 'full_name', fn (Builder $query) => $query->where('is_active','1'))
                    ->searchable()
                    ->preload()
                    ->optionsLimit(20)
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('bank.name')
                    ->searchable(),
                TextColumn::make('currency.name')
                    ->searchable(),
                TextColumn::make('coa_code')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
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
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBankAccounts::route('/'),
        ];
    }
}
