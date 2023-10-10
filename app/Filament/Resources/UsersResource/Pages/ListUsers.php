<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Models\Flooz;
use Closure;
use App\Models\Ria;
use App\Models\User;
use Filament\Actions;
use App\Models\Tmoney;
use App\Models\Xpress;
use App\Enums\TypesClass;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\UsersResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class ListUsers extends ListRecords
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getTableQuery(): ?Builder
    {

        $tmoneys = Tmoney::select('Montant','tmoneys.Type as Type','tmoneys.operation as operation','tmoneys.created_at as time','Commission', 'user_id as user_id',);

        $xpress =Xpress::select('Montant', 'xpresses.Type as Type', 'xpresses.operation  as operation','xpresses.created_at as time','commission as Comission' , 'user_id as user_id',);

        $flooz = Flooz::select('Montant', 'floozs.Type as Type', 'floozs.operation  as operation','floozs.created_at as time','Commission as Commission','user_id as user_id',);

        $ria = Ria::select('remboursement as Montant', 'rias.Type as Type', 'rias.operation  as operation','rias.created_at as time','Commission as Commission','user_id as user_id',)
        ->whereNotNull('remboursement');

        $unionQuery = $tmoneys->unionAll($xpress)->unionAll($flooz)->unionAll($ria);


        $query = static::getResource()::getEloquentQuery()
        ->select('users.id', 'Montant as Montant', 'Type as Type', 'operation as operation','Commission as Commission', 'user_id as user_id', 'time', )
        ->joinSub($unionQuery, 'temp_table', function (JoinClause $join) {
            $join->on('users.id', '=', 'temp_table.user_id');
        });
        
        return $query;


        
    }


}

