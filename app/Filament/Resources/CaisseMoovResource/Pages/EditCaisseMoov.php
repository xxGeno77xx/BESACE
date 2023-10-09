<?php

namespace App\Filament\Resources\CaisseMoovResource\Pages;

use App\Filament\Resources\CaisseMoovResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaisseMoov extends EditRecord
{
    protected static string $resource = CaisseMoovResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
