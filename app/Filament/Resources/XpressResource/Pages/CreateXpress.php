<?php

namespace App\Filament\Resources\XpressResource\Pages;

use App\Models\commission_xpress;
use Filament\Actions;
use App\Enums\TypesClass;
use App\Models\SoldeGlobal;
use App\Models\Solde_xpress;
use App\Filament\Resources\XpressResource;
use Filament\Resources\Pages\CreateRecord;

class CreateXpress extends CreateRecord
{
    protected static string $resource = XpressResource::class;

    public function afterCreate():void
    {
        $xpress=$this->record;

        $ancienSoldeXpress=Solde_xpress::first()->value('Montant');

        $ancienSoldeGLobal=SoldeGlobal::first()->value('Montant');

        if($xpress->Type == TypesClass::Retrait()->value)
        {
            Solde_xpress::first()->update([
                'Montant'=>( $ancienSoldeXpress + ($xpress->Montant))
            ]);

            SoldeGlobal::first()->update([
                'Montant'=>( $ancienSoldeGLobal - ($xpress->Montant))
            ]);
        }
        else
        {
            Solde_xpress::first()->update([
                        'Montant'=>( $ancienSoldeXpress -  ($xpress->Montant))
                    ]);

            SoldeGlobal::first()->update([
                'Montant'=>( $ancienSoldeGLobal +  ($xpress->Montant))
            ]);
        }

        $soldeDesCommissionsXpress= commission_xpress::first()->value('Montant');

        $ajoutCommission= $soldeDesCommissionsXpress +  $xpress->Commission;

        commission_xpress::first()->update([
            'Montant'=>  $ajoutCommission 
        ]);
      
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tauxCommissionRetrait=0.005;
        
        $tauxCommissionDepot=0.001;

        if($data['Type'] == TypesClass::Retrait()->value)
        {
            $data['Solde_xpress_restant'] = Solde_xpress::first()->value('Montant')  + $data['Montant'] ;

            $data['Commission'] = $data['Montant'] * $tauxCommissionRetrait;
        }
        else
        { 
            $data['Solde_xpress_restant'] = Solde_xpress::first()->value('Montant') - $data['Montant'] ;

            $data['Commission'] = $data['Montant'] * $tauxCommissionDepot;
        }

        return $data;
    }
}
