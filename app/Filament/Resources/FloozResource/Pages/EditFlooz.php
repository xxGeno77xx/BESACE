<?php

namespace App\Filament\Resources\FloozResource\Pages;

use App\Filament\Resources\FloozResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlooz extends EditRecord
{
    protected static string $resource = FloozResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
