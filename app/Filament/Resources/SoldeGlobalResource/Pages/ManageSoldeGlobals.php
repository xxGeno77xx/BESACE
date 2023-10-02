<?php

namespace App\Filament\Resources\SoldeGlobalResource\Pages;

use App\Filament\Resources\SoldeGlobalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSoldeGlobals extends ManageRecords
{
    protected static string $resource = SoldeGlobalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
