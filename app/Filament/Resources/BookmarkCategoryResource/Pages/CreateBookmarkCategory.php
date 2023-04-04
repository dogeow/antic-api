<?php

namespace App\Filament\Resources\BookmarkCategoryResource\Pages;

use App\Filament\Resources\BookmarkCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookmarkCategory extends CreateRecord
{
    protected static string $resource = BookmarkCategoryResource::class;
}
