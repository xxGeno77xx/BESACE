<?php

namespace App\Filament\Resources\SoldeFloozResource\Pages;

use App\Filament\Resources\SoldeFloozResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSoldeFloozs extends ManageRecords
{
    protected static string $resource = SoldeFloozResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
