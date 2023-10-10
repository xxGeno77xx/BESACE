<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\CaisseMoov;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CaisseMoovResource\Pages;
use App\Filament\Resources\CaisseMoovResource\RelationManagers;

class CaisseMoovResource extends Resource
{
    protected static ?string $model = CaisseMoov::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
         
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    TextColumn::make('Montant')
                                ->weight(FontWeight::Bold)
                                ->size(TextColumn\TextColumnSize::Large)
                                ->alignment('center'),
                ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCaisseMoovs::route('/'),
            'create' => Pages\CreateCaisseMoov::route('/create'),
            'edit' => Pages\EditCaisseMoov::route('/{record}/edit'),
        ];
    }    
}
