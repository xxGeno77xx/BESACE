<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Models\Ria;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\TypesClass;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Tables\Columns\JsonColumn;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Illuminate\Database\Query\Builder;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\RiaResource\Pages;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RiaResource\RelationManagers;

class RiaResource extends Resource
{
    protected static ?string $navigationGroup = 'Transferts d\'argent';
    protected static ?string $label = 'Ria';
    protected static ?string $pluralLabel = 'Ria';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $model = Ria::class;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('remboursement')
                    ->label('Remboursement')
                    ->hiddenOn('create'),
                DatePicker::make('date_remboursement')
                    ->HiddenOn('create'),
                Repeater::make('Montant')
                    ->schema([
                        TextInput::make('valeur')
                            ->required(),
                        DatePicker::make('Date')
                            ->required()
                            ->default(today())
                            ->displayFormat("d/m-y"),
                    ])
                    ->addActionLabel('Ajouter une opération')
                    ->columns(2),
                Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Hidden::make('Commission')
                    ->default(0),
                Hidden::make('operation')
                    ->default(TypesClass::Ria()->value),
                Hidden::make('Type')
                    ->default(TypesClass::Retrait()->value),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('remboursement')
                    ->tooltip(function (Model $record): string {

                        $arraySize = count($record->Montant);

                        $returnArray = [];

                        for ($i = 0; $i < $arraySize; $i++) {

                            $returnArray[$i] = $record->Montant[$i]['valeur'] . ' du ' . carbon::parse(($record->Montant[$i]['Date']))->format('d-m-y');

                        }
                        return implode(" ,", $returnArray);
                    })
                    // ->description(function (Model $record): string {

                    //     $arraySize = count($record->Montant);

                    //     $returnArray= [];

                    //     for($i= 0; $i <  $arraySize; $i++){

                    //         $returnArray[$i] = $record->Montant[$i]['valeur'];

                    //     }

                    // return implode(",", $returnArray);
                    // })
                    ->placeholder('Non rembousé.')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: '.',
                    ),
                JsonColumn::make('Montant')
                    ->label('Montants')
                    ->toggleable()
                    ->summarize(
                        Summarizer::make()
                    ),
                TextColumn::make('Commission')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: '.',
                    )
                    ->summarize([
                        Sum::make()->label('Commissions')
                    ]),
                TextColumn::make('date_remboursement')
                    ->label('Date du remboursement')
                    ->placeholder('-')
                    ->date('l, d-M-Y'),


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
            'index' => Pages\ListRias::route('/'),
            'create' => Pages\CreateRia::route('/create'),
            'edit' => Pages\EditRia::route('/{record}/edit'),
        ];
    }
}
