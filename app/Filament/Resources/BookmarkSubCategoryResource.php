<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookmarkSubCategoryResource\Pages;
use App\Models\BookmarkSubCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class BookmarkSubCategoryResource extends Resource
{
    protected static ?string $model = BookmarkSubCategory::class;

    protected static ?string $navigationLabel = '书签子分类';

    protected static ?string $breadcrumb = "书签子分类";

    protected static ?string $label = "书签子分类";

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = '书签';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bookmark_category_id')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('order'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bookmarkCategory.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->reorderable('order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookmarkSubCategories::route('/'),
            'create' => Pages\CreateBookmarkSubCategory::route('/create'),
            'edit' => Pages\EditBookmarkSubCategory::route('/{record}/edit'),
        ];
    }
}
