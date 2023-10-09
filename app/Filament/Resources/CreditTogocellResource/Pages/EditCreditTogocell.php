<?php

namespace App\Filament\Resources\CreditTogocellResource\Pages;

use App\Filament\Resources\CreditTogocellResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreditTogocell extends EditRecord
{
    protected static string $resource = CreditTogocellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
