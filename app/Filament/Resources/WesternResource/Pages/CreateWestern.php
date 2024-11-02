<?php

namespace App\Filament\Resources\WesternResource\Pages;

use Filament\Actions;
use App\Models\SoldeGlobal;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\WesternResource;

class CreateWestern extends CreateRecord
{
    protected static string $resource = WesternResource::class;


    public function beforeCreate():void
    {
        $western = $this->data;

        $solde = SoldeGlobal::first()->value('Montant');

        if($western["montant"] >= $solde)
        {
            Notification::make("warning")
                ->title("Solde insuffisant")
                ->body("Le solde de votre compte Togocell est insuffisant pour cette opération.")
                ->color(Color::Yellow)
                ->send();

            $this->halt();
        }


            
        
    }

    public function afterCreate():void
    {
        $western = intval($this->record->montant);

        $ancienSoldeGLobal = SoldeGlobal::first()->value('Montant');

            SoldeGlobal::first()->update([
                'Montant'=>( $ancienSoldeGLobal -  $western)
            ]);
        
    }
}


