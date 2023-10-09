<?php

namespace App\Filament\Resources\CaisseTogocellResource\Pages;

use App\Filament\Resources\CaisseTogocellResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCaisseTogocells extends ListRecords
{
    protected static string $resource = CaisseTogocellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
