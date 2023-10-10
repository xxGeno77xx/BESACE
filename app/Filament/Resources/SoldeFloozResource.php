<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Solde_flooz;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SoldeFloozResource\Pages;
use App\Filament\Resources\SoldeFloozResource\RelationManagers;

class SoldeFloozResource extends Resource
{
    protected static ?string $navigationGroup = 'Soldes';
    protected static ?string $label = 'Flooz';
    protected static ?string $pluralLabel = 'Flooz';
    protected static ?string $model = Solde_flooz::class;

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
                        ->size(TextColumn\TextColumnSize::Large)
                        ->alignment('center'),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSoldeFloozs::route('/'),
        ];
    }    
}
