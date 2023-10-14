<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use App\Models\CreditMoov;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Illuminate\Database\Query\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;

use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Count;
use Illuminate\Database\Eloquent\Builder as Build;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CreditMoovResource\Pages;
use App\Filament\Resources\CreditMoovResource\RelationManagers;

class CreditMoovResource extends Resource
{
    
    protected static ?string $navigationGroup = 'Crédit';
    protected static ?string $label = 'Moov';
    protected static ?string $pluralLabel = 'Moov';
    protected static ?string $model = CreditMoov::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Numéro_telephone')
                ->tel(),
                TextInput::make('Montant')
                ->numeric(),
                Select::make('Type_operation')
                ->options([
                    TypesClass::Forfait_appel()->value => 'Forfait appel',
                    TypesClass::Forfait_internet()->value => 'Forfait internet',
                    TypesClass::CreditSimple()->value => 'Crédit simple',
                ]),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Montant'),
                TextColumn::make('Numéro_telephone'),
                TextColumn::make('solde_restant_credit_moov'),
                BadgeColumn::make('Type_operation')
                ->colors([
                    'success' => static fn ($state): bool => $state === TypesClass::Forfait_internet()->value,
                    'primary' => static fn ($state): bool => $state === TypesClass::Forfait_appel()->value,
                    'danger' => static fn ($state): bool => $state === TypesClass::CreditSimple()->value,
                    'yellow' => static fn ($state): bool => $state === TypesClass::Recharge()->value,

                ])
                ->summarize([
                    Count::make()->query(fn (Builder $query) => $query->where('Type_operation', TypesClass::Recharge()->value))
                                ->label('Nombre de recharges'),   
                ]),
                TextColumn::make('created_at')
                ->label('Date')
                ->date('l,d-m-Y'),
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
                                    fn (Build $query, $date): Build => $query->whereDate('time', '>=' , $date)
                                )
                                ->when(
                                    $data['date_to'],
                                    fn (Build $query, $date):Build => $query->whereDate('time', '<=' , $date)
                                );    
                        })
                        ->indicateUsing(function (array $data): ?string {

                            if (( $data['date_from']) && ($data['date_from'])) {

                                return 'Du ' . Carbon::parse($data['date_from'])->format('d-m-Y')." au ".Carbon::parse($data['date_to'])->format('d-m-Y');
                            }
                            return null;
                        }),
                    SelectFilter::make('Type_operation')
                        ->multiple()                                 
                        ->label('Opération')
                        ->options([
                            TypesClass::Forfait_appel()->value => 'Forfait appel',
                            TypesClass::Forfait_internet()->value => 'Forfait internet',
                            TypesClass::CreditSimple()->value => 'Crédit simple',
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
            'index' => Pages\ListCreditMoovs::route('/'),
            'create' => Pages\CreateCreditMoov::route('/create'),
            'edit' => Pages\EditCreditMoov::route('/{record}/edit'),
        ];
    }    
}
