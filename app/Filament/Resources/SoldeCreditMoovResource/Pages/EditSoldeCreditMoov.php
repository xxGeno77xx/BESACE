<?php

namespace App\Filament\Resources\SoldeCreditMoovResource\Pages;

use App\Models\SoldeCreditMoov;
use Filament\Actions;
use App\Enums\TypesClass;
use App\Models\CaisseMoov;
use App\Models\CreditMoov;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SoldeCreditMoovResource;

class EditSoldeCreditMoov extends EditRecord
{
    protected static string $resource = SoldeCreditMoovResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function afterSave()
    {
       if($this->isAugmentedSolde())
       {
        CaisseMoov::first()->update([
            "Montant" => 0
        ]);
        CreditMoov::create([
            'Montant' => $this->data['Montant'],
            'Numéro_telephone'=> 22222222,
            'Type_operation'=> TypesClass::Recharge()->value,
            'solde_restant_credit_moov'=> $this->data['Montant'] 
        ]);
       }
    }

    public function isAugmentedSolde():bool
    {
        return SoldeCreditMoov::first()->value('Montant') < $this->data;
    }
}
