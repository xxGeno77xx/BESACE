<?php

namespace App\Filament\Resources\FloozResource\Pages;

use App\Models\commission_flooz;
use App\Models\Solde_flooz;
use Filament\Actions;
use App\Enums\TypesClass;
use App\Models\SoldeGlobal;
use App\Models\Solde_tmoney;
use App\Filament\Resources\FloozResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFlooz extends CreateRecord
{
    protected static string $resource = FloozResource::class;

    public function afterCreate():void
    {
        $tmoney=$this->record;

        $ancienSolde=Solde_flooz::first()->value('Montant');

        $ancienSoldeGLobal=SoldeGlobal::first()->value('Montant');

        $soldeDesCommissionsFlooz=commission_flooz::first()->value('Montant');

        if($tmoney->Type == TypesClass::Retrait()->value)
        {
            Solde_flooz::first()->update([
                'Montant'=>( $ancienSolde + ($tmoney->Commission) + ($tmoney->Montant))
            ]);

            SoldeGlobal::first()->update([
                'Montant'=>( $ancienSoldeGLobal -  ($tmoney->Montant))
            ]);
        }
        else
        {
            Solde_flooz::first()->update([
                        'Montant'=>( $ancienSolde + ($tmoney->Commission) - ($tmoney->Montant))
                    ]);

            SoldeGlobal::first()->update([
                'Montant'=>( $ancienSoldeGLobal +  ($tmoney->Montant))
            ]);
        }

        commission_flooz::first()->update([
            'Montant'=> $soldeDesCommissionsFlooz + ($tmoney->Commissison)
        ]);
      
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if($data['Type'] == TypesClass::Retrait()->value)
        {
            $data['solde_flooz_restant'] = Solde_flooz::first()->value('Montant') + $data['Commission'] + $data['Montant'] ;
        }
        else
        { 
            $data['solde_flooz_restant'] = Solde_flooz::first()->value('Montant') + $data['Commission'] - $data['Montant'] ;
        }

        return $data;
    }
}
