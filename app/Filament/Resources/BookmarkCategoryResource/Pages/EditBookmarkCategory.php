<?php

namespace App\Filament\Resources\BookmarkCategoryResource\Pages;

use App\Filament\Resources\BookmarkCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookmarkCategory extends EditRecord
{
    protected static string $resource = BookmarkCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
