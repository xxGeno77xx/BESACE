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
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\UsersResource\Pages;
use Filament\Tables\Actions\Action;
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
                    ->searchable(),
                TextColumn::make('operation')
                    ->searchable(),
                BadgeColumn::make('Type')
                    ->colors([
                        'success' => static fn ($state): bool => $state === TypesClass::Depot()->value,
                        'danger' => static fn ($state): bool => $state === TypesClass::Retrait()->value,
                    ]),
                BadgeColumn::make('Commission')
                        ->alignment('center')
                        ->color('success')
                        ->summarize([
                            Sum::make()->label('Total des  gains')
                                // ->query(fn (Build $query) => $query->where('Type', TypesClass::Depot()->value)),
                        ]),
                TextColumn::make('time')
                    ->date('l, d-m-Y à H:i')
                    ->label('Date et heure'),   
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

                            // $tmoneys = Tmoney::select('Montant','tmoneys.Type as Type','tmoneys.operation as operation','tmoneys.created_at as time','Commission as Commission', 'user_id as user_id');

                            // $xpress =Xpress::select('Montant', 'xpresses.Type as Type', 'xpresses.operation  as operation','xpresses.created_at as time','commission as Comission' , 'user_id as user_id');

                            // $flooz = Flooz::select('Montant', 'floozs.Type as Type', 'floozs.operation  as operation','floozs.created_at as time','Commission as Commission','user_id as user_id');

                            // $unionQuery = $tmoneys->unionAll($xpress)->unionAll($flooz);

                            // $query = User::select('Montant', 'Type as Type', 'operation as operation','Commission as Commission','time' )
                            //     ->joinSub($unionQuery, 'temp_table', function (JoinClause $join) {
                            //         $join->on('users.id', '=', 'temp_table.user_id');
                            //     });

                            // $tmoneys = Tmoney::select('Montant','tmoneys.Type as Type','tmoneys.operation as operation','tmoneys.created_at as time','Commission', 'user_id as user_id',);

                            // $xpress =Xpress::select('Montant', 'xpresses.Type as Type', 'xpresses.operation  as operation','xpresses.created_at as time','commission as Comission' , 'user_id as user_id',);

                            // $flooz = Flooz::select('Montant', 'floozs.Type as Type', 'floozs.operation  as operation','floozs.created_at as time','Commission as Commission','user_id as user_id',);

                            // $unionQuery = $tmoneys->unionAll($xpress)->unionAll($flooz);

                            // $query = User::select('users.id', 'Montant as Montant', 'Type as Type', 'operation as operation','Commission as Commission', 'user_id as user_id', 'time', )
                            // ->joinSub($unionQuery, 'temp_table', function (JoinClause $join) {
                            //     $join->on('users.id', '=', 'temp_table.user_id');
                            // });

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
