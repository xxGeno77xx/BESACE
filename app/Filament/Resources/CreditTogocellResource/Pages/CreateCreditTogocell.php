<?php

namespace App\Filament\Resources\CreditTogocellResource\Pages;

use App\Filament\Resources\CreditTogocellResource;
use App\Models\CaisseTogocell;
use App\Models\SoldeCreditTogocell;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCreditTogocell extends CreateRecord
{
    protected static string $resource = CreditTogocellResource::class;

    public function afterCreate():void
    {
        $togocell=$this->record;

        $soldeCreditTogocell=SoldeCreditTogocell::first()->value('Montant');

        $soldeCaisseTogocell= CaisseTogocell::first()->value('Montant');

        SoldeCreditTogocell::first()->update([
            'Montant' => $soldeCreditTogocell - $togocell->Montant
        ]);

        CaisseTogocell::first()->update([
            'Montant' =>  $soldeCaisseTogocell + $togocell->Montant
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {    
        $data['solde_restant_credit_togocell'] = SoldeCredittogocell::first()->value('Montant') -  $data['Montant'] ;

        return $data;
    }
}
