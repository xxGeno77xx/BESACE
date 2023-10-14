<?php

namespace App\Filament\Resources\SoldeCreditTogocellResource\Pages;

use App\Filament\Resources\SoldeCreditTogocellResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoldeCreditTogocells extends ListRecords
{
    protected static string $resource = SoldeCreditTogocellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
