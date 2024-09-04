<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemRequestResource\Pages;
use App\Filament\Resources\ItemRequestResource\RelationManagers;
use App\Models\ItemRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;

class ItemRequestResource extends Resource
{
    protected static ?string $model = ItemRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup= 'Admins Area';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        $currentUserId = Auth::id();
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship(name: 'department', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('year_session_id')
                    ->relationship(name: 'year_session', titleAttribute: 'name')
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
                Forms\Components\TextInput::make('item_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('estimate_cost')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('remarks')
                    ->required()
                    ->maxLength(255),   
                Forms\Components\Hidden::make('user_id')
                    ->default($currentUserId),           

                Select::make('recipients')
                    ->relationship('recipients', 'name')
                    ->multiple()
                    ->preload()
                    ->label('Recipients')
                    ->options(function () use ($currentUserId) {
                        return \App\Models\User::excludeCurrentUser($currentUserId)
                            ->pluck('name', 'id'); 
                    }),
                            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department Name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('year_session.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('term.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('week.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estimate_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                // Sender Column
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Sender')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Recipients Column
                Tables\Columns\TextColumn::make('recipients.name') 
                    ->label('Recipients'),
                    // ->formatStateUsing(fn ($state) => $state->pluck('name')->implode(', ')),
                
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
            'index' => Pages\ListItemRequests::route('/'),
            'create' => Pages\CreateItemRequest::route('/create'),
            'edit' => Pages\EditItemRequest::route('/{record}/edit'),
        ];
    }
}
