<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup= 'Admins Area';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('year_session_id')
                    ->relationship(name: 'yearSession', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('term_id')
                    ->relationship(name: 'term', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('week_id')
                    ->relationship(name: 'week', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('class_id')
                    ->relationship(name: 'class', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('stream_id')
                    ->relationship(name: 'streams', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('total_boys')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_girls')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('yearSession.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('term.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('week.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('class.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('streams.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_boys')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_girls')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
