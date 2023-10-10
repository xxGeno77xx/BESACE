<?php

namespace App\Filament\Resources\RiaResource\Pages;

use App\Filament\Resources\RiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRias extends ListRecords
{
    protected static string $resource = RiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
