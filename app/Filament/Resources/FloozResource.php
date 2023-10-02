<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Flooz;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FloozResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FloozResource\RelationManagers;

class FloozResource extends Resource
{
    protected static ?string $navigationGroup = 'Transferts';
    protected static ?string $label = 'Flooz';
    protected static ?string $pluralLabel = 'Flooz';
    protected static ?string $model = Flooz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Montant'),
                TextInput::make('Commission'),
                TextInput::make('Téléphone'),
                Select::make('Type')
                ->options([
                    TypesClass::Retrait()->value => 'Retrait',
                    TypesClass::Depot()->value => 'Dépot'
                ]),
                Hidden::make('solde_flooz_restant')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Téléphone')
                ->numeric(),
                TextColumn::make('Montant')
                ->numeric(),
                TextColumn::make('Commission')
                ->numeric(), 
                TextColumn::make('solde_flooz_restant'),
                BadgeColumn::make('Type')
                ->colors([
                    'success' => static fn ($state): bool => $state === TypesClass::Depot()->value,
                    'danger' => static fn ($state): bool => $state === TypesClass::Retrait()->value,
                ]),
                TextColumn::make('created_at')
                ->label('Date')
                ->date('H:i d-m-Y'),

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
            'index' => Pages\ListFloozs::route('/'),
            'create' => Pages\CreateFlooz::route('/create'),
            'edit' => Pages\EditFlooz::route('/{record}/edit'),
        ];
    }    
}
