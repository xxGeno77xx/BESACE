<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CaisseTogocell;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CaisseTogocellResource\Pages;
use App\Filament\Resources\CaisseTogocellResource\RelationManagers;

class CaisseTogocellResource extends Resource
{
    protected static ?string $model = CaisseTogocell::class;
    protected static ?string $navigationGroup = 'Caisses';

    protected static ?string $label = 'Caisse togocell';
    protected static ?string $pluralLabel = 'Caisse togocell';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Montant'),
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
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCaisseTogocells::route('/'),
            // 'create' => Pages\CreateCaisseTogocell::route('/create'),
            // 'edit' => Pages\EditCaisseTogocell::route('/{record}/edit'),
        ];
    }    
}
