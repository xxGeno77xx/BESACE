<?php

namespace App\Filament\Resources\XpressResource\Pages;

use App\Filament\Resources\XpressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditXpress extends EditRecord
{
    protected static string $resource = XpressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
