<?php

namespace App\Filament\Resources\CaisseMoovResource\Pages;

use App\Filament\Resources\CaisseMoovResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCaisseMoovs extends ListRecords
{
    protected static string $resource = CaisseMoovResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
