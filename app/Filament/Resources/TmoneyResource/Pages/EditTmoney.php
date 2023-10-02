<?php

namespace App\Filament\Resources\TmoneyResource\Pages;

use App\Filament\Resources\TmoneyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTmoney extends EditRecord
{
    protected static string $resource = TmoneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
