<?php

namespace App\Filament\Resources\XpressResource\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SoldeXpressW extends Widget
{
    protected static string $view = 'filament.resources.xpress-resource.widgets.solde-xpress-w';

    protected function getStats(): array
    {
        return [


        Card::make('Caisse','ddd')
            ->description('32k increase')
            ->chart([mt_rand(1, 50),mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)])
            ->color("success"),
        ];
    }
}
