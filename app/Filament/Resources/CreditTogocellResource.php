<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use Filament\Tables\Table;
use App\Models\CreditTogocell;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CreditTogocellResource\Pages;
use App\Filament\Resources\CreditTogocellResource\RelationManagers;

class CreditTogocellResource extends Resource
{
    protected static ?string $navigationGroup = 'Crédit';
    protected static ?string $label = 'Togocell';
    protected static ?string $pluralLabel = 'Togocell';
    protected static ?string $model = CreditTogocell::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Montant')
                ->numeric(),
                TextInput::make('Numéro_telephone')
                ->tel(),
                Select::make('Type_operation')
                ->options([
                    TypesClass::Forfait_appel()->value => 'Forfait appel',
                    TypesClass::Forfait_internet()->value => 'Forfait internet',
                    TypesClass::CreditSimple()->value => 'Crédit simple',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Montant'),
                TextColumn::make('Numéro_telephone'),
                TextColumn::make('solde_restant_credit_togocell'),
                BadgeColumn::make('Type_operation')
                            ->colors([
                                'success' => static fn ($state): bool => $state === TypesClass::Forfait_internet()->value,
                                'primary' => static fn ($state): bool => $state === TypesClass::Forfait_appel()->value,
                                'danger' => static fn ($state): bool => $state === TypesClass::CreditSimple()->value,
                            ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCreditTogocells::route('/'),
            'create' => Pages\CreateCreditTogocell::route('/create'),
            'edit' => Pages\EditCreditTogocell::route('/{record}/edit'),
        ];
    }    
}
