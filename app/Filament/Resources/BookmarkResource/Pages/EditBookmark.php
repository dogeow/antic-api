<?php

namespace App\Filament\Resources\BookmarkResource\Pages;

use App\Filament\Resources\BookmarkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookmark extends EditRecord
{
    protected static string $resource = BookmarkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
