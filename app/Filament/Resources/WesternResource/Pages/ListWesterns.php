<?php

namespace App\Filament\Resources\WesternResource\Pages;

use App\Filament\Resources\WesternResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWesterns extends ListRecords
{
    protected static string $resource = WesternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
