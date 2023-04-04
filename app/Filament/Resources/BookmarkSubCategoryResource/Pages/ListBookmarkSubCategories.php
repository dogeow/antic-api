<?php

namespace App\Filament\Resources\BookmarkSubCategoryResource\Pages;

use App\Filament\Resources\BookmarkSubCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookmarkSubCategories extends ListRecords
{
    protected static string $resource = BookmarkSubCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
