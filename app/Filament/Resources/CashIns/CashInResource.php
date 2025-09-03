<?php

namespace App\Filament\Resources\CashIns;

use App\Filament\Resources\CashIns\Pages\CreateCashIn;
use App\Filament\Resources\CashIns\Pages\EditCashIn;
use App\Filament\Resources\CashIns\Pages\ListCashIns;
use App\Filament\Resources\CashIns\Pages\ViewCashIn;
use App\Filament\Resources\CashIns\Schemas\CashInForm;
use App\Filament\Resources\CashIns\Schemas\CashInInfolist;
use App\Filament\Resources\CashIns\Tables\CashInsTable;
use App\Models\CashIn;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CashInResource extends Resource
{
    protected static ?string $model = CashIn::class;

    protected static string|UnitEnum|null $navigationGroup = 'Cash And Bank';

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return CashInForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CashInInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CashInsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCashIns::route('/'),
            'create' => CreateCashIn::route('/create'),
            'view' => ViewCashIn::route('/{record}'),
            'edit' => EditCashIn::route('/{record}/edit'),
        ];
    }
}
