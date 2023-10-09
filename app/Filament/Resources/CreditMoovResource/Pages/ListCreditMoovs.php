<?php

namespace App\Filament\Resources\CreditMoovResource\Pages;

use App\Filament\Resources\CreditMoovResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreditMoovs extends ListRecords
{
    protected static string $resource = CreditMoovResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
