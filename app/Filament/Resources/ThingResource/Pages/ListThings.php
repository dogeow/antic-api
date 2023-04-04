<?php

namespace App\Filament\Resources\ThingResource\Pages;

use App\Filament\Resources\ThingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThings extends ListRecords
{
    protected static string $resource = ThingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
