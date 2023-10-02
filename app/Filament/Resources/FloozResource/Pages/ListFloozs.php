<?php

namespace App\Filament\Resources\FloozResource\Pages;

use App\Filament\Resources\FloozResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFloozs extends ListRecords
{
    protected static string $resource = FloozResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
