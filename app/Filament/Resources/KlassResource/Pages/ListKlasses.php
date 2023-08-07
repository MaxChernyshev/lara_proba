<?php

namespace App\Filament\Resources\KlassResource\Pages;

use App\Filament\Resources\KlassResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKlasses extends ListRecords
{
    protected static string $resource = KlassResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
