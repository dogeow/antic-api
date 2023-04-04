<?php

namespace App\Filament\Resources\BookmarkCategoryResource\Pages;

use App\Filament\Resources\BookmarkCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookmarkCategories extends ListRecords
{
    protected static string $resource = BookmarkCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
