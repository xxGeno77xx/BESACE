<?php

namespace App\Filament\Resources\RiaResource\Pages;

use Filament\Actions;
use App\Models\SoldeGlobal;
use App\Filament\Resources\RiaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRia extends CreateRecord
{
    protected static string $resource = RiaResource::class;

    public function afterCreate()
    {
        $ria= $this->record;

        $MontantTotalPaye = 0;
        $MontantPaye = $ria->Montant; // array

        for($i= 0; $i < count($MontantPaye); $i++){

            $MontantTotalPaye =  $MontantTotalPaye + $MontantPaye[$i]['valeur'];
        }

        $ancienSoldeGLobal = SoldeGlobal::first()->value('Montant');
        
        SoldeGlobal::first()->update([
            'Montant'=>( $ancienSoldeGLobal - $MontantTotalPaye)
        ]);
    }
}
