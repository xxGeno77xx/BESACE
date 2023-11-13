<?php

namespace App\Filament\Resources\CreditMoovResource\Pages;

use App\Filament\Resources\CreditMoovResource;
use App\Models\CaisseMoov;
use App\Models\SoldeCreditMoov;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCreditMoov extends CreateRecord
{
    protected static string $resource = CreditMoovResource::class;

    public function afterCreate():void
    {
        $moov=$this->record;

        $soldeCreditMoov = SoldeCreditMoov::first()->value('Montant');


        $soldeCaisseMoov = CaisseMoov::first()->value('Montant');

        SoldeCreditMoov::first()->update([
            'Montant' => $soldeCreditMoov - $moov->Montant
        ]);


        CaisseMoov::first()->update([
            'Montant' =>  $soldeCaisseMoov + $moov->Montant
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {    
        $data['solde_restant_credit_moov'] = SoldeCreditMoov::first()->value('Montant') -  $data['Montant'] ;

        return $data;
    }

}
