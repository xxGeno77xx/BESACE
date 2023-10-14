<?php

namespace App\Filament\Widgets;

use App\Models\CaisseMoov;
use App\Models\CaisseTogocell;
use App\Models\Solde_flooz;
use App\Models\Solde_tmoney;
use App\Models\Solde_xpress;
use App\Models\SoldeCreditMoov;
use App\Models\SoldeCreditTogocell;
use App\Models\SoldeGlobal;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class caisse extends BaseWidget
{
    protected static ?string $pollingInterval = '1s';
    protected function getStats(): array
    {
        return [


        Card::make('Caisse', number_format(SoldeGlobal::first()->value('Montant'), 0, '.', '.'))
            ->description('32k increase')
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->color("success"),
        
        Card::make('Caisse Togocell', CaisseTogocell::first()->value('Montant'))
            ->description('7% increase')
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->color("primary"),

        Card::make('Caisse Moov', number_format(CaisseMoov::first()->value('Montant'), 0, '.', '.'))
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->description('3% increase')
            ->color("primary"),

        Card::make('Solde Tmoney', number_format(Solde_tmoney::first()->value('Montant'), 0, '.', '.'))
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->description('3% increase')
            ->color("primary"),

        Card::make('Solde Flooz', number_format(Solde_flooz::first()->value('Montant'), 0, '.', '.' ))
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->description('3% increase')
            ->color("primary"),

        Card::make('Solde Xpress', number_format(Solde_xpress::first()->value('Montant') , 0, '.', '.' ))
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->description('3% increase')
            ->color("primary"),

        Card::make('Solde crédit Moov', number_format(SoldeCreditMoov::first()->value('Montant') , 0, '.', '.' ))
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->description('3% increase')
            ->color("primary"),
            
        Card::make('Solde crédit Togocell', number_format(SoldeCreditTogocell::first()->value('Montant') , 0, '.', '.' ))
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->description('3% increase')
            ->color("primary"),

    
        ];
    }

    
}
