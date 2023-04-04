<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages;
use App\Filament\Resources\SiteResource\RelationManagers;
use App\Models\Site;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationLabel = '站点';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('domain')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_online')
                    ->required(),
                Forms\Components\Toggle::make('is_new')
                    ->required(),
                Forms\Components\TextInput::make('path')
                    ->maxLength(255),
                Forms\Components\TextInput::make('seo')
                    ->required(),
                Forms\Components\TextInput::make('get_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('date_xpath')
                    ->maxLength(255),
                Forms\Components\TextInput::make('date_format')
                    ->maxLength(255),
                Forms\Components\TextInput::make('keyword')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('note'),
                Forms\Components\DateTimePicker::make('last_updated_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('domain'),
                Tables\Columns\IconColumn::make('is_online')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_new')
                    ->boolean(),
                Tables\Columns\TextColumn::make('path'),
                Tables\Columns\TextColumn::make('seo'),
                Tables\Columns\TextColumn::make('get_type'),
                Tables\Columns\TextColumn::make('date_xpath'),
                Tables\Columns\TextColumn::make('date_format'),
                Tables\Columns\TextColumn::make('keyword'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('note')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('last_updated_at')
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
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSite::route('/create'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
        ];
    }
}
