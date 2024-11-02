<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Flooz;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Query\Builder  ;
use Illuminate\Database\Eloquent\Builder as Build;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\FloozResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FloozResource\RelationManagers;

class FloozResource extends Resource
{
    protected static ?string $navigationGroup = 'Transferts d\'argent';
    protected static ?string $label = 'Flooz';
    protected static ?string $pluralLabel = 'Flooz';
    protected static ?string $model = Flooz::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Montant'),
                TextInput::make('Commission'),
                TextInput::make('Téléphone'),
                Select::make('Type')
                ->native(false)
                ->options([
                    TypesClass::Retrait()->value => 'Retrait',
                    TypesClass::Depot()->value => 'Dépot'
                ]),
                Hidden::make('solde_flooz_restant'),
                Hidden::make('user_id')
                        ->default(auth()->user()->id),
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
                Filter::make('created_at')
                ->label('Date')
                        ->form([
                            Grid::make(2) 
                            ->schema([
                                DatePicker::make('date_from')
                                    ->label("Du"),
                                DatePicker::make('date_to')
                                    ->label("Au"),
                            ])->columns(1)
                        ])
                        ->query(function (Build $query, array $data): Build {

                            return $query
                                ->when(
                                    $data['date_from'],
                                    fn (Build $query, $date): Build => $query->whereDate('created_at', '>=' , $date)
                                )
                                ->when(
                                    $data['date_to'],
                                    fn (Build $query, $date):Build => $query->whereDate('created_at', '<=' , $date)
                                );    
                        })
                        ->indicateUsing(function (array $data): ?string {

                            if (( $data['date_from']) && ($data['date_from'])) {

                                return 'Du ' . Carbon::parse($data['date_from'])->format('d-m-Y')." au ".Carbon::parse($data['date_to'])->format('d-m-Y');
                            }
                            return null;
                        }),
                    SelectFilter::make('Type')
                        ->multiple()                                 
                        ->label('Opération')
                        ->options([
                            TypesClass::Retrait()->value => 'Retraits',
                            TypesClass::Depot()->value => 'Dépôts',
                        ])
                ], layout: FiltersLayout::AboveContentCollapsible)
                ->filtersTriggerAction(
                    fn (Action $action) => $action
                        ->button()
                        ->label('Filtrer les résultats'),
                )
            
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
