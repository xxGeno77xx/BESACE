<?php

namespace App\Filament\Resources\SoldeTmoneyResource\Pages;

use App\Filament\Resources\SoldeTmoneyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoldeTmoneys extends ListRecords
{
    protected static string $resource = SoldeTmoneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
