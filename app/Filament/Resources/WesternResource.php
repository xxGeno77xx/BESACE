<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WesternResource\Pages;
use App\Filament\Resources\WesternResource\RelationManagers;
use App\Models\Western;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WesternResource extends Resource
{
    protected static ?string $model = Western::class;

    protected static ?string $navigationGroup = 'Transferts d\'argent';

    protected static ?string $label = 'Western Union';
    protected static ?string $pluralLabel = 'Western Unions';

    protected static ?string $navigationIcon = 'icon-wu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                    ->schema([
                        TextInput::make("reference")
                        ->unique(ignoreRecord:true),

                        TextInput::make("montant"),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListWesterns::route('/'),
            'create' => Pages\CreateWestern::route('/create'),
            'edit' => Pages\EditWestern::route('/{record}/edit'),
        ];
    }
}
