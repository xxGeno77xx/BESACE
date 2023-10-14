<?php

namespace App\Filament\Resources\SoldeCreditMoovResource\Pages;

use App\Filament\Resources\SoldeCreditMoovResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoldeCreditMoovs extends ListRecords
{
    protected static string $resource = SoldeCreditMoovResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
