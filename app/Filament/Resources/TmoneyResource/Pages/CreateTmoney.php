<?php

namespace App\Filament\Resources\TmoneyResource\Pages;

use App\Enums\TypesClass;
use App\Filament\Resources\TmoneyResource;
use App\Models\Solde_tmoney;
use App\Models\SoldeGlobal;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTmoney extends CreateRecord
{
    protected static string $resource = TmoneyResource::class;

    public function afterCreate():void
    {
        $tmoney=$this->record;

        $ancienSolde=Solde_tmoney::first()->value('Montant');

        $ancienSoldeGLobal=SoldeGlobal::first()->value('Montant');

        if($tmoney->Type == TypesClass::Retrait()->value)
        {
            Solde_tmoney::first()->update([
                'Montant'=>( $ancienSolde + ($tmoney->Commission) + ($tmoney->Montant))
            ]);

            SoldeGlobal::first()->update([
                'Montant'=>( $ancienSoldeGLobal -  ($tmoney->Montant))
            ]);
        }
        else
        {
            Solde_tmoney::first()->update([
                        'Montant'=>( $ancienSolde + ($tmoney->Commission) - ($tmoney->Montant))
                    ]);

            SoldeGlobal::first()->update([
                'Montant'=>( $ancienSoldeGLobal +  ($tmoney->Montant))
            ]);
        }
      
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if($data['Type'] == TypesClass::Retrait()->value)
        {
            $data['solde_tmoney_restant'] = Solde_tmoney::first()->value('Montant') + $data['Commission'] + $data['Montant'] ;
        }
        else
        { 
            $data['solde_tmoney_restant'] = Solde_tmoney::first()->value('Montant') + $data['Commission'] - $data['Montant'] ;
        }

        return $data;
    }
}
