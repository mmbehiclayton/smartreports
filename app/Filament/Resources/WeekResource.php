<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeekResource\Pages;
use App\Filament\Resources\WeekResource\RelationManagers;
use App\Models\Week;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeekResource extends Resource
{
    protected static ?string $model = Week::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    protected static ?string $navigationGroup= 'System Settings';

    protected static ?string $slug= 'term-weeks';

    protected static ?int $navigationSort= 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('term_id')
                    ->relationship(name: 'term', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('term.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListWeeks::route('/'),
            'create' => Pages\CreateWeek::route('/create'),
            'edit' => Pages\EditWeek::route('/{record}/edit'),
        ];
    }
}
