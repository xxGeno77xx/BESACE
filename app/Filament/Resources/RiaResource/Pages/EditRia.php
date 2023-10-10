<?php

namespace App\Filament\Resources\RiaResource\Pages;

use App\Models\Ria;
use Filament\Actions;
use App\Models\SoldeGlobal;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\RiaResource;
use Filament\Resources\Pages\EditRecord;

class EditRia extends EditRecord
{
    protected static string $resource = RiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function afterSave()
    {
     
    //    $updateValues= $data;

        $MontantTotalPaye = 0;

        $ria= $this->record;
           
        $MontantPaye = $ria->Montant; // array

        for($i= 0; $i < count($MontantPaye); $i++){

            $MontantTotalPaye =  $MontantTotalPaye + $MontantPaye[$i]['valeur'];
        }

        $ria->update([
            'Commission'=> $ria->remboursement - $MontantTotalPaye
        ]);


    }
}
