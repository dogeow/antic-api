<?php

namespace App\Filament\Resources\BookmarkResource\Pages;

use App\Filament\Resources\BookmarkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookmarks extends ListRecords
{
    protected static string $resource = BookmarkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
