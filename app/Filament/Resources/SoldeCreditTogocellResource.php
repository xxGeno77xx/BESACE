<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\SoldeCreditTogocell;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use App\Filament\Resources\SoldeCreditTogocellResource\Pages;
use App\Filament\Resources\SoldeCreditTogocellResource\RelationManagers;

class SoldeCreditTogocellResource extends Resource
{
    protected static ?string $model = SoldeCreditTogocell::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Montant')
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    TextColumn::make('Montant')
                            ->weight(FontWeight::Bold)
                            ->size(TextColumnSize::Large)
                            ->alignment('center'),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('RECHARGER'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->contentGrid([
                'md' => 1,
                'xl' => 1,
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
            'index' => Pages\ListSoldeCreditTogocells::route('/'),
            'create' => Pages\CreateSoldeCreditTogocell::route('/create'),
            'edit' => Pages\EditSoldeCreditTogocell::route('/{record}/edit'),
        ];
    }    
}
