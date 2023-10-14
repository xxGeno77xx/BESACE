<?php

namespace App\Filament\Resources\SoldeCreditTogocellResource\Pages;

use App\Enums\TypesClass;
use App\Models\CreditTogocell;
use Filament\Actions;
use App\Models\CaisseTogocell;
use App\Models\SoldeCreditTogocell;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SoldeCreditTogocellResource;

class EditSoldeCreditTogocell extends EditRecord
{
    protected static string $resource = SoldeCreditTogocellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function afterSave()
    {
       if($this->isAugmentedSolde())
       {
        CaisseTogocell::first()->update([
            "Montant" => 0
        ]);
        CreditTogocell::create([
            'Montant' => $this->data['Montant'],
            'Numéro_telephone'=> 22222222,
            'Type_operation'=> TypesClass::Recharge()->value,
            'solde_restant_credit_togocell'=> $this->data['Montant'] 
        ]);
       }
    }

    public function isAugmentedSolde():bool
    {
        return SoldeCreditTogocell::first()->value('Montant') < $this->data;
    }
}
