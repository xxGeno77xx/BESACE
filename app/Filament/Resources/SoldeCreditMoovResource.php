<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SoldeCreditMoov;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use App\Filament\Resources\SoldeCreditMoovResource\Pages;
use App\Filament\Resources\SoldeCreditMoovResource\RelationManagers;

class SoldeCreditMoovResource extends Resource
{
    protected static ?string $model = SoldeCreditMoov::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Soldes';

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
            'index' => Pages\ListSoldeCreditMoovs::route('/'),
            'create' => Pages\CreateSoldeCreditMoov::route('/create'),
            'edit' => Pages\EditSoldeCreditMoov::route('/{record}/edit'),
        ];
    }    
}
