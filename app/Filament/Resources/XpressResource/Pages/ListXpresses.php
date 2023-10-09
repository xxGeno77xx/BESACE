<?php

namespace App\Filament\Resources\XpressResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\XpressResource;
use XpressResource\Widgets\SoldeXpressWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class ListXpresses extends ListRecords
{
    protected static string $resource = XpressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

   
    protected function getHeaderWidgets(): array
    {
        return [
            // XpressResource\Widgets\SoldeXpressW::class,
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return static::getResource()::getEloquentQuery()->select('Xpresses.*');
    }
}
