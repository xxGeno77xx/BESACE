<?php

namespace App\Filament\Resources\CaisseTogocellResource\Pages;

use App\Filament\Resources\CaisseTogocellResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaisseTogocell extends EditRecord
{
    protected static string $resource = CaisseTogocellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
