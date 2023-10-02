<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Xpress;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;


use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Resources\XpressResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\XpressResource\Pages\EditXpress;
use App\Filament\Resources\XpressResource\RelationManagers;
use App\Filament\Resources\XpressResource\Pages\CreateXpress;
use App\Filament\Resources\XpressResource\Pages\ListXpresses;

class XpressResource extends Resource
{
    protected static ?string $model = Xpress::class;
    protected static ?string $navigationGroup = 'Transferts';
    protected static ?string $label = 'Xpress';
    protected static ?string $pluralLabel = 'Xpress';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Montant'),
                TextInput::make('Téléphone')
                ->tel(),
                TextInput::make('Nom_client')
                ->label('Nom du client'),
                Select::make('Type')
                ->options([
                    TypesClass::Retrait()->value => 'Retrait',
                    TypesClass::Depot()->value => 'Dépot'
                ]),
                // Hidden::make('solde_Xpress_restant')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Montant')
                    ->searchable(),
                TextColumn::make('Téléphone'),
                TextColumn::make('Nom_client')
                    ->searchable(),
                BadgeColumn::make('Type')
                    ->colors([
                        'success' => static fn ($state): bool => $state === TypesClass::Depot()->value,
                        'danger' => static fn ($state): bool => $state === TypesClass::Retrait()->value,
                    ]),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->date('H:i d-m-Y'),
                TextColumn::make('commission'),
                TextColumn::make('solde_Xpress_restant'),
            ])
            ->filters([
                Filter::make('created_at')
                        ->form([
                            Grid::make(2) 
                            ->schema([

                                DatePicker::make('date_from')
                                ->label("Du"),

                                DatePicker::make('date_to')
                                    ->label("Au"),

                            ])->columns(1)
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['date_from'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                                )
                                ->when(
                                    $data['date_to'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                                );
                        })
                        ->indicateUsing(function (array $data): ?string {
                            if (( $data['date_from']) && ($data['date_from'])) {
                                return 'Du ' . Carbon::parse($data['date_from'])->format('d-m-Y')." au ".Carbon::parse($data['date_to'])->format('d-m-Y');
                            }
                            return null;
                        }),

                SelectFilter::make('Type')
                            ->options([
                                TypesClass::Depot()->value => 'Dépôt',
                                TypesClass::Retrait()->value => 'Retrait',
                            ])
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
            'index' => Pages\ListXpresses::route('/'),
            'create' => Pages\CreateXpress::route('/create'),
            'edit' => Pages\EditXpress::route('/{record}/edit'),
        ];
    }    
    
    public static function getWidgets(): array
    {
        return [
            XpressResource\Widgets\SoldeXpressW::class,
        ];
    }
}