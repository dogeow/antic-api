<?php

namespace App\Filament\Resources\ThingResource\Pages;

use App\Filament\Resources\ThingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThing extends EditRecord
{
    protected static string $resource = ThingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
