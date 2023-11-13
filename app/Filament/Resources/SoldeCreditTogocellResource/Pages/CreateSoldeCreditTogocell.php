<?php

namespace App\Filament\Resources\SoldeCreditTogocellResource\Pages;

use App\Models\CaisseTogocell;
use App\Models\CreditTogocell;
use App\Models\SoldeCreditTogocell;
use Filament\Actions;
use App\Enums\TypesClass;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SoldeCreditTogocellResource;

class CreateSoldeCreditTogocell extends CreateRecord
{
    protected static string $resource = SoldeCreditTogocellResource::class;

    
}
