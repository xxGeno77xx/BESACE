<?php

namespace App\Filament\Resources\SoldeTmoneyResource\Pages;

use App\Filament\Resources\SoldeTmoneyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSoldeTmoney extends EditRecord
{
    protected static string $resource = SoldeTmoneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
