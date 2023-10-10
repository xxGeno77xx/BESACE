<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Flooz;
use App\Models\Tmoney;
use App\Models\Xpress;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Filament\Forms\Components\ColorPicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\UsersResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UsersResource\RelationManagers;

class UsersResource extends Resource
{
    protected static ?string $label = 'Historique des opérations';
    protected static ?string $pluralLabel = 'Historique des opérations';
    protected static ?string $model = User::class;

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
                TextColumn::make('Montant')
                    ->searchable()
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: '.',
                    )->color('grey'),
                    TextColumn::make('operation')
                    ->searchable()
                    ->colors([
                        'info' => static fn ($state): bool => $state === TypesClass::Xpress()->value,
                        'fuschia' => static fn ($state): bool => $state === TypesClass::Tmoney()->value,
                        'amber' => static fn ($state): bool => $state === TypesClass::Ria()->value,
                        'gray' => static fn ($state): bool => $state === TypesClass::Flooz()->value,
                    ])
                    ->sortable(),
                BadgeColumn::make('Type')
                    ->colors([
                        'success' => static fn ($state): bool => $state === TypesClass::Depot()->value,
                        'danger' => static fn ($state): bool => $state === TypesClass::Retrait()->value,
                    ]),
                BadgeColumn::make('Commission')
                        ->alignment('center')
                        ->color('success')
                        ->summarize([
                            Sum::make()->label('Total des commisisons')
                                // ->query(fn (Build $query) => $query->where('Type', TypesClass::Depot()->value)),
                        ]),
                TextColumn::make('time')
                    ->date('l, d.MY')
                    ->label('Date et heure')
                    ->sortable(),   
            ])
            ->filters([
                Filter::make('time')
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
                        ->query(function (Builder $query, array $data): Builder {

                            return $query
                                ->when(
                                    $data['date_from'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('time', '>=' , $date)
                                )
                                ->when(
                                    $data['date_to'],
                                    fn (Builder $query, $date):Builder => $query->whereDate('time', '<=' , $date)
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
                        TypesClass::Depot()->value => 'Dépôts',
                        TypesClass::Retrait()->value => 'Retraits',
                    ]),

                SelectFilter::make('operation')
                    ->multiple()                                 
                    ->label('Opération')
                    ->options([
                        TypesClass::Tmoney()->value => 'Tmoney',
                        TypesClass::Xpress()->value => 'Xpress',
                        TypesClass::Ria()->value => 'Ria',
                        TypesClass::Western()->value => 'Western Union',
                        TypesClass::FLooz()->value => 'Flooz',
                    ])
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filtrer les résultats'),
            )
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('time', 'desc')
            ->recordUrl(null);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
        ];
    }    


}
