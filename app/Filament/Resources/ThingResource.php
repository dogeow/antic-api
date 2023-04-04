<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThingResource\Pages;
use App\Filament\Resources\ThingResource\RelationManagers;
use App\Models\Thing;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThingResource extends Resource
{
    protected static ?string $model = Thing::class;

    protected static ?string $navigationLabel = '背包';

    protected static ?string $breadcrumb = "背包";

    protected static ?string $label = "背包";

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('amount')
                    ->required(),
                Forms\Components\TextInput::make('money'),
                Forms\Components\TextInput::make('place_id'),
                Forms\Components\DatePicker::make('bought_at')->label('购买时间'),
                Forms\Components\DatePicker::make('expired_at')->label('过期时间'),
                Forms\Components\Toggle::make('is_expiration_reminder')->label('过期提醒'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('money'),
                Tables\Columns\TextColumn::make('place_id'),
                Tables\Columns\TextColumn::make('bought_at')->label('购买时间')
                    ->date(),
                Tables\Columns\TextColumn::make('expired_at')->label('过期时间')
                    ->date(),
                Tables\Columns\IconColumn::make('is_expiration_reminder')->label('过期提醒')
                    ->boolean(),
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
            'index' => Pages\ListThings::route('/'),
            'create' => Pages\CreateThing::route('/create'),
            'edit' => Pages\EditThing::route('/{record}/edit'),
        ];
    }
}
