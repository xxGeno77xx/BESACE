<?php

namespace App\Filament\Resources\CreditMoovResource\Pages;

use Filament\Actions;
use App\Models\CaisseMoov;
use App\Models\SoldeCreditMoov;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CreditMoovResource;

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


    protected function beforeCreate()
    {
        $togocell = $this->data;

        $soldeCreditTogocell = SoldeCreditMoov::first()->Montant;

        if ( $soldeCreditTogocell - intval($togocell["Montant"]) <= 0) {

            Notification::make("warning")
                ->title("Solde insuffisant")
                ->body("Le solde de votre compte Togocell est insuffisant pour cette opération.")
                ->color(Color::Yellow)
                ->send();

            $this->halt();
        };
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {    
        $data['solde_restant_credit_moov'] = SoldeCreditMoov::first()->value('Montant') -  $data['Montant'] ;

        return $data;
    }

}
