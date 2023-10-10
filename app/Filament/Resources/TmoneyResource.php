<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;

use Filament\Tables;
use App\Models\Tmoney;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use Filament\Tables\Table;
use App\Models\Solde_tmoney;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\TmoneyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TmoneyResource\RelationManagers;

class TmoneyResource extends Resource
{

    protected static ?string $navigationGroup = 'Transferts d\'argent';
    protected static ?string $label = 'Tmoney';
    protected static ?string $pluralLabel = 'Tmoney';
    protected static ?string $model = Tmoney::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

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
                Hidden::make('user_id')
                    ->default(auth()->user()->id),        
            ]);
                                  
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Montant')
                ->numeric(),
                TextColumn::make('Téléphone')
                ->numeric(),
                BadgeColumn::make('Type')
                ->colors([
                    'success' => static fn ($state): bool => $state === TypesClass::Depot()->value,
                    'danger' => static fn ($state): bool => $state === TypesClass::Retrait()->value,
                ]),
                TextColumn::make('created_at')
                ->label('Date')
                ->date('H:i d-m-Y'),
                TextColumn::make('Commission')
                ->numeric(
                    decimalPlaces: 0,
                    decimalSeparator: '.',
                    thousandsSeparator: '.',
                )
                ->summarize([
                    Sum::make()->label('Commissions')
                ]), 
                TextColumn::make('solde_tmoney_restant'),
               
               
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
            'index' => Pages\ListTmoneys::route('/'),
            'create' => Pages\CreateTmoney::route('/create'),
            'edit' => Pages\EditTmoney::route('/{record}/edit'),
        ];
    }    

    protected function getFormStatePath(): string 
    {
        return 'data';
    } 
}
