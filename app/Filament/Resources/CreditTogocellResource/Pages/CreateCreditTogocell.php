<?php

namespace App\Filament\Resources\CreditTogocellResource\Pages;

use Filament\Actions;
use App\Models\CaisseTogocell;
use Filament\Support\Colors\Color;
use App\Models\SoldeCreditTogocell;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CreditTogocellResource;

class CreateCreditTogocell extends CreateRecord
{
    protected static string $resource = CreditTogocellResource::class;

    public function afterCreate(): void
    {
        $togocell = $this->record;

        $soldeCreditTogocell = SoldeCreditTogocell::first()->value('Montant');

        $soldeCaisseTogocell = CaisseTogocell::first()->value('Montant');

        SoldeCreditTogocell::first()->update([
            'Montant' => $soldeCreditTogocell - $togocell->Montant
        ]);

        CaisseTogocell::first()->update([
            'Montant' =>  $soldeCaisseTogocell + $togocell->Montant
        ]);
    }


    protected function beforeCreate()
    {
        $togocell = $this->data;

        $soldeCreditTogocell = SoldeCreditTogocell::first()->Montant;

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
        $data['solde_restant_credit_togocell'] = SoldeCredittogocell::first()->value('Montant') -  $data['Montant'];

        return $data;
    }
}
