<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookmarkResource\Pages;
use App\Models\Bookmark;
use App\Models\BookmarkCategory;
use App\Models\BookmarkSubCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class BookmarkResource extends Resource
{
    protected static ?string $model = Bookmark::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = '书签';

    protected static ?string $breadcrumb = "书签";

    protected static ?string $label = "书签";

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = '书签';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'url'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            '网址' => $record->url,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('bookmark_category_id')
                    ->options(BookmarkCategory::all()->pluck('name', 'id'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('bookmark_sub_category_id', null))
                    ->required(),
                Forms\Components\Select::make('bookmark_sub_category_id')
                    ->options(function (callable $get) {
                        $category = BookmarkCategory::find($get('bookmark_category_id'));

                        if (! $category) {
                            return BookmarkSubCategory::all()->pluck('name', 'id');
                        }

                        return $category->subCategories->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bookmarkCategory.name'),
                Tables\Columns\TextColumn::make('bookmarkSubCategory.name'),
                Tables\Columns\TextColumn::make('title')->url(function ($record) {
                    return $record->url;
                }, true),
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
            ]);
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
            'index' => Pages\ListBookmarks::route('/'),
            'create' => Pages\CreateBookmark::route('/create'),
            'edit' => Pages\EditBookmark::route('/{record}/edit'),
        ];
    }
}
