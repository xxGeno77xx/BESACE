<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;

use Filament\Tables;
use App\Models\Tmoney;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\TmoneyResource\Pages;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Count;
use Illuminate\Database\Eloquent\Builder as Build;


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
                ->date('d-m-Y H:i '),
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
